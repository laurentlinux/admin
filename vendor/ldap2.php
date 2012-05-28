<?php

class LdapConnection
{
  private $connection = null;

  public function getConnection() {
      return $this->connection;
  }

  public function connect($server = null, $user = null, $password = null)
  {
    $ldapConn = ldap_connect($server);
    if ( $ldapConn )
    {
      ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);
      if ( ldap_bind( $ldapConn, $user, $password) )
      {
        $this->connection = $ldapConn;
        return true;
      }
    }
  }

  /**
	 * throw an error, getting the needed info from the connection object
	 */
  private function ldapError()
  {
    $connection = $this->connection;
    throw new Exception(
       'Error: ('. ldap_errno($connection) .') '. ldap_error($connection)
    );
  }


/**
  * throw an error, getting the needed info from the connection object
  */
  public function disconnect()
  {
    ldap_unbind($this->connection);
  }
}

class Ldap extends LdapConnection
{

	/**
	 * The absolute url for the user's profile.
	 *
	 * @var string
	 */
	private $baseDn;
/**
	 * The absolute url for the user's profile.
	 *
	 * @var string
	 */
	private $searchFilter;
/**
	 * The absolute url for the user's profile.
	 *
	 * @var array
	 */
	private $attributesToFetch = Array();

	public function __construct($domain) {
      $this->baseDn = strtr(substr($domain, strpos($domain, '.')), array('.' => ',dc='));
      $this->searchFilter = "cn=*";
  }


	/**
  * Search an LDAP server
  */
  public function search($basedn, $filter, $attributes, $toArray = false)
  {
    $connection = parent::getConnection();
    $results = ldap_search($connection, $basedn, $filter, $attributes);
    if ($results)
    {
      if ($toArray)
        return $this->resultToArray($results);
      else 
        return ldap_get_entries($connection, $results);
    }
  }

  /**
  * Add a new contact
  */
  public function add($basedn, $username, $password, $admin, $firstname, $lastname, $mail, $mailalias = null)
  {
    //set up our entry array
    $contact = array();
    $contact['objectclass'][0] = 'inetOrgPerson';
    $contact['objectclass'][1] = 'mailAccount';

    //add our data
    $contact['sn'] = $lastname;
    $contact['displayName'] = $firstname .' '. $lastname;
    $contact['givenName'] = $firstname;
    $contact['mail'] = $mail;
    $contact['uid'] = $username;
    $contact['userPassword'] = $password;

    //Create the CN entry
    $contact['cn'] = $firstname .' '. $lastname;

    //create the DN for the entry
    $dn = 'cn='. $contact['cn'] .','. $basedn;

    //add the entry
    $connection = parent::getConnection();
    if (!ldap_add($connection, $dn, $contact))
    {
      //the add failed, lets raise an error and hopefully find out why
      parent::ldapError();
      return false;
    } else {
      $host = substr($basedn, strpos($basedn, ',dc='));
      if ($admin)
        return $this->grantAdmin('cn='.$firstname.' '.$lastname.',ou=users'.$host);
      return true;
    }
  }

  /**
  * Modify an existing contact
  */
  public function modify($basedn, $dnToEdit, $username, $password, $admin, $firstname, $lastname, $mail, $mailalias)
  {
    //get a reference to the current entry
    $connection = parent::getConnection();

    //set the new values
    $contact['sn'] = $lastname;
    $contact['displayName'] = $firstname .' '. $lastname;
    $contact['givenName'] = $firstname;
    $contact['mail'] = $mail;
    $contact['MAILALIAS'] = $mailalias;
    $contact['uid'] = $username;
    $contact['userPassword'] = $password;

    //remove any empty entries
    foreach ($contact as $key => $value) {
      if (empty($value)) {
        unset($contact[$key]);
      }
    }

    //Find the new CN - in case the first or last name has changed
    $cn = 'cn='. $firstname .' '. $lastname;

    //rename the record (handling if the first/last name have changed)
    $changed = ldap_rename($connection, $dnToEdit, $cn, null, true);
    if ($changed)
    {
      //find the DN for the potentially revised name
      $newdn = $cn .','. $basedn;

      //now we can apply any changes in the contact information
      ldap_mod_replace($connection, $newdn, $contact);

      $host = substr($basedn, strpos($basedn, ',dc='));
      return $this->grantAdmin('cn='.$firstname.' '.$lastname.$host);
    }
    else
    {
      parent::ldapError();
      return false;
    }
  }


 /**
  * Remove an existing contact
  */
  public function delete($dnToDelete)
  {
    $connection = parent::getConnection();
    if (!ldap_delete($connection, $dnToDelete)) {
      parent::ldapError();
      return false;
    } else return $this->revokeAdmin($dnToDelete);
  }


  /**
  * Grant a user as admin
  */
  public function grantAdmin($dnToGrant)
  {
    //get a reference to the current entry
    $connection = parent::getConnection();

    $host = substr($dnToGrant, strpos($dnToGrant, ',dc='));

    $adminList = $this->search('cn=admin,ou=groups'.$host, 'cn=admin', array("member"));
    foreach ($adminList[0]['member'] as $admin) {
      if (!is_numeric($admin))
        $admins['member'][] = $admin;
    }
    $admins['member'][] = $dnToGrant;

    if (!ldap_mod_replace($connection, 'cn=admin,ou=groups'.$host, $admins))
    {
      $this->ldapError();
      return false;
    } else {
      return true;
    }
  }


 /**
  * Revoke jedi power for a user
  */
  public function revokeAdmin($dnToRevoke)
  {
    //get a reference to the current entry
    $connection = parent::getConnection();

    $host = substr($dnToRevoke, strpos($dnToRevoke, ',dc='));

    $adminList = $this->search('cn=admin,ou=groups'.$host, 'cn=admin', array("member"));
    foreach ($adminList[0]['member'] as $admin) {
      if (!is_numeric($admin) && ($admin != $dnToRevoke))
        $admins['member'][] = $admin;
    }
    
    if (!ldap_mod_replace($connection, 'cn=admin,ou=groups'.$host, $admins))
    {
      parent::ldapError();
      return false;
    } else {
      return true;
    }
  }


 /**
  * Install the LDAP background
  */
  public function install($basedn, $basedomain) {
    $connection = parent::getConnection();

    $sudo['objectclass'][0] = 'organizationalUnit';
    $sudo['objectclass'][1] = 'top';
    $sudo['ou'] = 'sudo';
    if (!ldap_add($connection, 'ou=sudo'.$basedn, $sudo))
      parent::ldapError();

    $sudoAdmin['objectclass'][0] = 'sudoRole';
    $sudoAdmin['objectclass'][1] = 'top';
    $sudoAdmin['sudoHost'] = 'ALL';
    $sudoAdmin['sudoCommand'] = 'ALL';
    $sudoAdmin['sudoOption'] = '!authenticate';
    $sudoAdmin['cn'] = 'admin';
    $sudoAdmin['sudoUser'] = 'admin';
    if (!ldap_add($connection, 'cn=admin,ou=sudo'.$basedn, $sudoAdmin))
      parent::ldapError();

    $sudoWWW['objectclass'][0] = 'sudoRole';
    $sudoWWW['objectclass'][1] = 'top';
    $sudoWWW['sudoHost'] = 'ALL';
    $sudoWWW['sudoCommand'] = '/usr/bin/yunohost';
    $sudoWWW['sudoOption'] = '!authenticate';
    $sudoWWW['cn'] = 'www-data';
    $sudoWWW['sudoUser'] = 'www-data';
    if (!ldap_add($connection, 'cn=www-data,ou=sudo'.$basedn, $sudoWWW))
      parent::ldapError();

    $domains['objectclass'][0] = 'organizationalUnit';
    $domains['objectclass'][1] = 'top';
    $domains['ou'] = 'domains';
    if (!ldap_add($connection, 'ou=domains'.$basedn, $domains))
      parent::ldapError();

    $virtualdomain['objectclass'][0] = 'mailDomain';
    $virtualdomain['objectclass'][1] = 'top';
    $virtualdomain['virtualdomain'] = $basedomain;
    if (!ldap_add($connection, 'virtualdomain='.$basedomain.',ou=domains'.$basedn, $virtualdomain))
      parent::ldapError();

    $groups['objectclass'][0] = 'organizationalUnit';
    $groups['objectclass'][1] = 'top';
    $groups['ou'] = 'groups';
    if (!ldap_add($connection, 'ou=groups'.$basedn, $groups))
      parent::ldapError();
    
    $users['objectclass'][0] = 'organizationalUnit';
    $users['objectclass'][1] = 'top';
    $users['ou'] = 'users';
    if (!ldap_add($connection, 'ou=users'.$basedn, $users))
      parent::ldapError();
    
    $admins['objectclass'][0] = 'groupOfNames';
    $admins['objectclass'][1] = 'top';
    $admins['cn'] = 'admin';
    $admins['member'] = 'cn=admin'.$basedn;
    if (!ldap_add($connection, 'cn=admin,ou=groups'.$basedn, $admins))
      parent::ldapError();

    $admins['objectclass'][0] = 'groupOfNames';
    $admins['objectclass'][1] = 'top';
    $admins['cn'] = 'apps';
    $admins['member'] = 'cn=roundcube';
    if (!ldap_add($connection, 'cn=apps,ou=groups'.$basedn, $admins))
      parent::ldapError();

    $admins['objectclass'][0] = 'organizationalRole';
    $admins['objectclass'][1] = 'posixAccount';
    $admins['objectclass'][2] = 'simpleSecurityObject';
    $admins['uidNumber'] = '1337';
    $admins['gidNumber'] = '1337';
    $admins['homeDirectory'] = '/home/admin';
    $admins['loginShell'] = '/bin/bash';
    $admins['uid'] = 'admin';
    if (!ldap_mod_replace($connection, 'cn=admin'.$host, $admins))
      parent::ldapError();

    return true;    
  }

  /**
  * Convert an LDAP search result into an array
  */
  public function resultToArray($result)
  {
    $connection = parent::getConnection();
    $resultArray = array();

    if ($result)
    {
      $entry = ldap_first_entry($connection, $result);
      while ($entry)
      {
        $row = array();
        $attr = ldap_first_attribute($connection, $entry);
        while ($attr)
        {
          $val = ldap_get_values_len($connection, $entry, $attr);
          if (array_key_exists('count', $val) AND $val['count'] == 1)
          {
            $row[strtolower($attr)] = $val[0];
          }
          else
          {
            $row[strtolower($attr)] = $val;
          }

          $attr = ldap_next_attribute($connection, $entry);
        }
        $resultArray[] = $row;
        $entry = ldap_next_entry($connection, $entry);
      }
    }
    return $resultArray;
  }
}
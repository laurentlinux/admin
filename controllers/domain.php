<?php

 /**
  *  YunoHost - Self-hosting for all
  *  Copyright (C) 2012  Kload <kload@kload.fr>
  *
  *  This program is free software: you can redistribute it and/or modify
  *  it under the terms of the GNU Affero General Public License as
  *  published by the Free Software Foundation, either version 3 of the
  *  License, or (at your option) any later version.
  *
  *  This program is distributed in the hope that it will be useful,
  *  but WITHOUT ANY WARRANTY; without even the implied warranty of
  *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  *  GNU Affero General Public License for more details.
  *
  *  You should have received a copy of the GNU Affero General Public License
  *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
  */
  

/**
 * GET /domain
 */
function domains () {
  redirect_to('/domain/list');
}

/**
 * GET /domain/list
 */
function listDomains () {
  global $ldap;
  
  $domains = $ldap->findAll('(objectClass=mailDomain)');
  set('domains', $domains);
  set('title', T_('List of domains'));
  return render("listDomains.html.php");
}

/**
 * PUT /domain/update
 */
function updateDomains () {
  global $ldap;

  $error = false;
  
  foreach ($_POST['domains'] as $domain) {
    if (!empty($domain)) {
      $domains[] = htmlspecialchars($domain);
      foreach ($_POST['actualDomains'] as $key => $actualDomain) {
        if ($domain == $actualDomain) unset($_POST['actualDomains'][$key]);
      }
    }
  }

  if (!empty($_POST['actualDomains'])) {
    foreach ($_POST['actualDomains'] as $domainToDelete) {
      $error = !$ldap->deleteVirtualdomain(array('virtualdomain' => $domainToDelete));
    }
  }
  

  if (isset($domains)) {
    foreach ($domains as $domain) {
      if (!$ldap->findOneBy(array('virtualdomain' => $domain))) {
        $ldap->setVirtualdomainVirtualdomain($domain); // Verbose epicness
        $error = !$ldap->saveVirtualdomain();
      }
    }
  } else flash('error', T_('You must enter at least one domain.'));

  if ($error) flash('error', T_('A problem occured on domain operations.'));
  else flash('success', T_('Domains succefully updated.'));

  redirect_to('/domain/list');
}
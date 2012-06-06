<?php 

 /**
  *  Yunohost - Self-hosting for all
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
  
class User extends LdapEntry 
{
    var $options = array
    (
        'dnPattern'     => array('cn' => ''),
        'searchPath'    => array('ou' => 'users'),
        'objectClass'   => array('inetOrgPerson', 'mailAccount')
    );


    var $fields = array
    (
        'description' => array
        (       
            'required' => false
        ),
        'givenname' => array
        (       
            'required'  => true,
            'minLength' => 1,
            'maxlength' => 30
        ),
        'sn' => array
        (       
            'required'  => true,
            'minLength' => 1,
            'maxlength' => 30
        ),
        'displayname' => array
        (       
            'required'  => true,
            'unique'    => true,
            'minLength' => 2,
            'maxlength' => 62
        ),
        'cn' => array
        (       
            'required'  => true,
            'unique'    => true,
            'minLength' => 2,
            'maxlength' => 62
        ),
        'uid' => array
        (       
            'required'  => true,
            'unique'    => true,
            'minLength' => 2,
            'maxlength' => 30,
            'unique'    => true
        ),
        'userpassword' => array
        (       
            'required' => true
        ),
        'mail' => array
        (       
            'required'  => true,
            'unique'    => true,
            'maxlength' => 100,
            'pattern'   => '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'
        ),
        'mailalias' => array
        (   
            'required'  => false,
            'maxlength' => 100,
            'pattern'   => '#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#'
        )
    );
    
    public function beforeSave() 
    {
        $fullname = $this->givenname.' '.$this->sn;

        $this->cn           = $fullname;
        $this->displayname  = $fullname;
        $this->dnPattern    = array('cn' => $fullname);
    }

    public function afterSave() {}

}

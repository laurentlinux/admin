<?php 

 /**
  *  Yunohost - Self-hosting for dummies
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

class Virtualdomain extends LdapEntry 
{
	var $options = array
	(
        'dnPattern'     => array('virtualdomain' => ''),
				'searchPath' 	=> array('ou' => 'domains'),
				'objectClass' 	=> array('mailDomain', 'top')
	);


	var $fields = array
	(
		'virtualdomain' => array
		(		
			'required' => true,
			'unique'	=> true,
        )
	);
    
    public function beforeSave() 
    {
        $this->dnPattern = array('virtualdomain' => $this->virtualdomain);
    }

}
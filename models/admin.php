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

class Admin extends LdapEntry 
{
	var $options = array
	(
        'dnPattern'     => array('cn' => 'admin'),
				'searchPath' 		=> array('ou' => 'groups'),
				'objectClass' 	=> array('groupOfNames', 'top')
	);


	var $fields = array
	(
			'cn' => array
			(		
					'required' => true
		  ),
			'member' => array
			(		
					'required' => true,
	        'pattern' => '#^cn=#'
	    ),
	);
    
    public function beforeSave() 
    {
        $this->cn  = 'admin';
    }

}
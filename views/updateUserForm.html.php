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

 ?>
<form action="/user/update/<?php echo $user['uid'] ?>" method="post" class="row row-tab useradd">
	<input type="hidden" name="_method" value="PUT" id="_method">
	<input type="hidden" name="user" value="<?php echo $name ?>" id="user">
	<div class="span6">
		<div class="well">
			<h3 class="center"><?php echo T_('User informations') ?></h3>
		    <br /><br />
		    <p class="row">
			    <label class="span2 labeluser" for="domain"><?php echo T_('Domain') ?> <span style="color: red">*</span></label>
			    <select class="span3" style="" type="text" name="domain" id="domain">
			    	<?php foreach ($domains as $domain) { ?>
				  		<option value="<?php echo $domain['virtualdomain'] ?>"><?php echo $domain['virtualdomain'] ?></option>
				  	<?php } ?>
				</select> 
		    </p>
			<p class="row">
			    <label class="span2 labeluser" for="username"><?php echo T_('Username') ?> <span style="color: red">*</span></label>
			    <input class="span3" type="text" name="username" id="username" required value="<?php echo $user['uid'] ?>" />
		    </p>
		    <p class="row">
			    <label class="span2 labeluser" for="firstname"><?php echo T_('Firstname') ?> <span style="color: red">*</span></label>
			    <input class="span3" type="text" name="firstname" id="firstname" required value="<?php echo $user['givenname'] ?>" />
		    </p>
		    <p class="row">
			    <label class="span2 labeluser" for="lastname"><?php echo T_('Lastname') ?> <span style="color: red">*</span></label>
			    <input class="span3" type="text" name="lastname" id="lastname" required value="<?php echo $user['sn'] ?>" />
		    </p>
		    <p class="row">
			    <label class="span2 labeluser" for="mail"><?php echo T_('Mail') ?> <span style="color: red">*</span></label>
			    <input class="span3" type="text" name="mail" id="mail" required value="<?php echo $user['mail'] ?>" />
		    </p>
		    <p class="row">
			    <div class="span3">
				    <label class="span2 labeladmin" style="text-align: right" for="isadmin"><strong><?php echo T_('Administrator') ?></strong></label>
				    <input class="span1" style="margin: 2px 0 0 10px;" type="checkbox" name="isadmin" id="isadmin" <?php if ('admin' === $user['description']) echo 'checked'; ?> />
			    </div>
		    </p>
		    <div style="clear: both; height: 20px;"></div>
		    <p class="center">
		    	<a class="btn" href="/user/mailaliases/<?php echo $user['uid'] ?>">
		    		<i class="icon-envelope" style="margin: 2px 6px 0 0;"></i><?php echo T_('Mail aliases') ?>
		    	</a>
		    	<a class="btn" href="/user/password/<?php echo $user['uid'] ?>">
		    		<i class="icon-lock" style="margin: 2px 6px 0 0;"></i><?php echo T_('Change password') ?>
		    	</a>
		    </p>

		    
				<div style="clear: both;"></div>
				<hr>
		    <p class="row" style="text-align: center;">
		    	<span style="color: red">*</span> <small><?php echo T_('required fields') ?></small>
		    </p>
		    <p class="row" style="text-align: center;">
		    	<input class="btn btn-primary btn-large" type="submit" value="<?php echo T_('Update') ?>" />
		    </p>
		</div>
	</div>
	<div style="clear: both;"></div>
</form>
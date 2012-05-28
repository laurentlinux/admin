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
 <form action="/user/password/<?php echo $uid ?>" method="post" class="row row-tab useradd">
	<input type="hidden" name="_method" value="PUT" id="_method">
	<div class="span6">
		<div class="well">
			<h3 class="center"><?php echo T_('Change password') ?></h3>
		    <br /><br />
		    <p class="row">
			    <label class="span2 labeluser" for="actualPassword"><?php echo T_('Actual') ?> <span style="color: red">*</span></label>
			    <input class="span3" type="password" name="actualPassword" id="actualPassword" placeholder="<?php echo T_('Actual password') ?>" />
		    </p>
		    <p class="row">
			    <label class="span2 labeluser" for="newPassword"><?php echo T_('New') ?> <span style="color: red">*</span></label>
			    <input class="span3" type="password" name="newPassword" id="newPassword" placeholder="<?php echo T_('New password') ?>" />
		    </p>
		    <p class="row">
			    <label class="span2 labeluser" for="newPassword2"><?php echo T_('Retype new') ?> <span style="color: red">*</span></label>
			    <input class="span3" type="password" name="newPassword2" id="newPassword2" placeholder="<?php echo T_('New password') ?>" />
		    </p>
		   	<div style="clear: both;"></div>
			<hr>
			<p class="row" style="text-align: center;">
		    	<span style="color: red">*</span> <small><?php echo T_('required fields') ?></small>
		    </p>
		    <p class="row" style="text-align: center;">
		    	<input class="btn btn-primary btn-large" type="submit" value="<?php echo T_('Save') ?>" />
		    </p>
		</div>
	</div>
	<div style="clear: both;"></div>
</form>
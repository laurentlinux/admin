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

 ?>
<form action="/user/mailaliases/<?php echo $user['uid'] ?>" method="post" class="row row-tab useradd">
	<input type="hidden" name="_method" value="PUT" id="_method">
	<div class="span6">
		<div class="well">
			<h3 class="center"><?php echo T_('Mail aliases') ?></h3>
		    <br /><br />
		    <p class="row mailrow">
			    <label class="span2 labeluser" for="mail"><?php echo T_('Main address') ?></label>
			    <input class="span3" type="text" name="mail" id="mail" value="<?php echo $user['mail'] ?>" disabled />
		    </p>
		    <p class="row mailrow parentaliasrow" style="display: none;">
			    <label class="span2 labeluser" for="mail"><?php echo T_('Alias') ?></label>
			    <input class="span3" type="text" name="mailalias[]" placeholder="<?php echo T_('New mail alias') ?>" />
			    <a href="#" class="removeAlias"><i class="icon-remove-sign"></i></a>
		    </p>
		    <?php foreach ($user['mailalias'] as $mailalias) { ?>
				    	<p class="row mailrow aliasrow">
						    <label class="span2 labeluser" for="mail"><?php echo T_('Alias') ?></label>
						    <input class="span3" type="text" name="mailalias[]" value="<?php echo $mailalias ?>" />
						    <a href="#" class="removeAlias"><i class="icon-remove-sign"></i></a>
				    	</p>
		    <?php } ?>
		    <p class="row" style="text-align: center;">
		    	<a class="btn" id="addAlias"><i class="icon-plus" style="margin: 2px 5px 0 0;"></i><?php echo T_('Add an alias') ?></a>
		    </p>
		   	<div style="clear: both;"></div>
			<hr>
		    <p class="row" style="text-align: center;">
		    	<input class="btn btn-primary btn-large" type="submit" value="<?php echo T_('Save') ?>" />
		    </p>
		</div>
	</div>
	<div style="clear: both;"></div>
</form>
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
 <form action="/user/delete" method="post" class="row row-tab useradd">
	<input type="hidden" name="_method" value="DELETE" id="_method">
	<input type="hidden" name="user" value="<?php echo $username ?>" id="user">
	<div class="span6 center well">
		<h3><?php echo sprintf(T_('Do you really want to delete %s ?'), strtoupper($username)) ?></h3>
		<br/>
		<p><strong><?php echo T_('Name') ?> : </strong><?php echo $name ?></p>
		<p><strong><?php echo T_('Mail') ?> : </strong><?php echo $mail ?></p>
		<br />
		<input type="submit" class="btn btn-danger btn-large" value="<?php echo T_('Delete') ?>" />
		<div style="clear: both;"></div>
	</div>
</form>
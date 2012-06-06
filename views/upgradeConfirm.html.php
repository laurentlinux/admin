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

 ?>
 <form action="/tools/upgrade/packages" method="post" class="row row-tab useradd">
	<div class="span6 center well">
		<h3><?php echo sprintf(T_('You have %s packages to upgrade.'), $number) ?></h3>
    <br />
	  <p id="upgrade-result" style="text-align: left; font-family: monospace; font-size: 10px;"></p>
		<input type="submit" class="btn btn-primary btn-large" value="<?php echo T_('Upgrade') ?>" id="system-upgrade" />
		<div style="clear: both;"></div>
	</div>
</form>
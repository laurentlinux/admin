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
 <div class="row row-tab">
	<div class="span6 well">
		<?php foreach ($result as $line) { ?>
			<div><?php echo $line ?></div>
		<?php } ?>
		<br />
		<?php if ($errorCode) { ?>
			<div style="color: green"><strong><?php echo T_('Success !') ?></strong></div>
		<?php } else { ?>
			<div style="color: red"><strong><?php echo T_('Failed !') ?></strong></div>
		<?php } ?>
		<div style="clear: both; margin-top: 20px;"></div>
		<a class="btn btn-primary" href="/app/list"><i class="icon-chevron-left icon-white" style="margin: 2px 6px 0 0"></i><?php echo T_('Back') ?></a>
	</div>
</div>
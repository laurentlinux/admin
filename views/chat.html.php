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
	<div class="span6 center well">
		<?php if (!isset($_SESSION['chat'])) { ?>
			<h3><?php echo T_('Statut') ?>: <span style="color: #E9322D"><?php echo T_('Stopped') ?></span></h3>
			<br/>
			<p><?php echo T_('Do you want to enable the support chat ?') ?></p>
			<br />
			<a href="/tools/chat/enable" class="btn btn-success btn-large" title="<?php echo T_('Enable chat') ?>">
				<?php echo T_('Enable') ?>
			</a>
		<?php } else { ?>
			<h3><?php echo T_('Statut') ?>: <span style="color: #46a546"><?php echo T_('Running') ?></span></h3>
			<br/>
			<p><?php echo T_('Do you want to disable the support chat ?') ?></p>
			<br />
			<a href="/tools/chat/disable" class="btn btn-danger btn-large" title="<?php echo T_('Disable chat') ?>" onclick="disconnectMini();">
				<?php echo T_('Disable') ?>
			</a>
		<?php } ?>
	</div>
	<div style="clear: both;"></div>
</div>
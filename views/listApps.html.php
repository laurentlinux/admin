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
<div class="row row-tab">
	<?php foreach ($appPkgNames as $key => $app) { ?>
		<div class="span6"> 
			<div class="well">
				<div class="row">
					<div class="avatar span2">
						<img src="<?php echo PUBLIC_DIR ?>/img/app.jpg" />
					</div>
					<div class="span">
						<strong><?php echo ucfirst($app); ?></strong> 
						<?php if (isset($upgradableApps[$key])) { ?>
							 - <span style="color: blue">Upgradable</span>
						<?php } elseif (isset($installedApps[$key])) { ?>
							 - <span style="color: green">Installed</span>
						<?php } ?>
						<div class="maillist">
						 <?php echo $appDesc[$key]; ?></div>
					</div>
					<div class="span1" style="margin-left: 3px; width: 100px; float: right;">
						<div style="text-align: right">
							<?php if (isset($upgradableApps[$key])) { ?>
								<a href="/app/update/<?php echo $app ?>" title="<?php echo T_('Update').' '.ucfirst($app) ?>" class="btn btn-info"><i class="icon-refresh icon-white" style="margin: 2px 6px 0 0"></i><?php echo T_('Upgrade') ?></a>
							<?php } elseif (isset($installedApps[$key])) { ?>
								<a href="/app/remove/<?php echo $app ?>" title="<?php echo T_('Uninstall').' '.ucfirst($app) ?>" class="btn btn-danger"><i class="icon-trash icon-white" style="margin: 2px 6px 0 0"></i><?php echo T_('Uninstall') ?></a>
							<?php } else {?>
								<a href="/app/install/<?php echo $app ?>" title="<?php echo T_('Install').' '.ucfirst($app) ?>" class="btn btn-success"><i class="icon-download-alt icon-white" style="margin: 2px 6px 0 0"></i><?php echo T_('Install') ?></a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
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
	<div class="span6">
		<div class="well">
			<h3 class="center"><?php echo T_('Monitoring') ?></h3>
			<br />
			<div class="row-fluid">
				<div class="span3 right" style="width: 22%"><?php echo T_('CPU') ?></div>
				<div class="progress progress-striped progress-info active span8" style="float: right; width: 74%">
			    <div class="bar" style="width: <?php echo $cpu[0] ?>%;"></div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span3 right" style="width: 22%"><?php echo T_('Memory') ?></div>
				<div class="progress progress-striped progress-danger active span8" style="float: right; width: 74%">
			    <div class="bar" style="width: <?php echo round($memory[1]/$memory[0]*100) ?>%;"></div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span3 right" style="width: 22%"><?php echo T_('Swap') ?></div>
				<div class="progress progress-striped active span8" style="float: right; width: 74%">
			    <div class="bar" style="width: <?php echo round($swap[1]/$swap[0]*100) ?>%;"></div>
				</div>
			</div>
			<div class="row-fluid">
				<div class="span3 right" style="width: 22%"><?php echo T_('Tasks') ?></div>
				<div class="span8" style="float: right; width: 74%"><?php echo $tasks[0] ?></div>
			</div>
		</div>
	</div>
	<div class="span6">
		<div class="well">
			<h3 class="center"><?php echo T_('Network') ?></h3>
			<br />
			<div class="row-fluid">
				<div class="span3 right" style="width: 22%"><?php echo T_('Local IP') ?></div>
				<div class="span8" style="float: right; width: 74%"><strong><?php echo $localIP ?></strong></div>
			</div>
			<br />
			<div class="row-fluid">
				<div class="span3 right" style="width: 22%"><?php echo T_('Global IP') ?></div>
				<div class="span8" style="float: right; width: 74%"><strong><?php echo $globalIP ?></strong></div>
			</div>
			<br />
			<div class="row-fluid">
				<div class="span3 right" style="width: 22%"><?php echo T_('MAC address') ?></div>
				<div class="span8" style="float: right; width: 74%"><strong><?php echo $macAddr ?></strong></div>
			</div>
		</div>
	</div>
</div>
<div class="row row-tab">
	<?php foreach ($report as $service => $running) { ?>
		<div class="span6">
			<div class="well">
				<div class="row">
					<div class="span1">
						<?php if ($running) { ?>
							<a class="btn btn-small btn-success"><i class="icon-ok icon-white"></i></a>
						<?php } else { ?>
							<a class="btn btn-small btn-danger"><i class="icon-remove icon-white"></i></a>
						<?php } ?>
					</div>
					<div class="span" style="margin-left: 0;margin-top: 4px;"><strong><?php echo $service ?></strong></div>
					<div class="span" style="margin-left: 3px; float: right;">
						<div style="text-align: right">
							<a title="<?php echo T_('Log') ?>" class="btn btn-small disabled"><i class="icon-list-alt"></i> <?php echo T_('Log') ?></a>
							<?php if (!$running) { ?>
							<a title="<?php echo T_('Activate') ?>" class="btn btn-small disabled"><i class="icon-ok-sign"></i> <?php echo T_('Activate') ?></a>
							<?php } else { ?>
							<a title="<?php echo T_('Deactivate') ?>" class="btn btn-small disabled"><i class="icon-remove-sign"></i> <?php echo T_('Deactivate') ?></a>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</div>
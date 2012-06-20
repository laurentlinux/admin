<?php

 /**
  *  YunoHost - Self-hosting for all
  *  Copyright (C) 2012
  *     Kload <kload@kload.fr>
  *     Guillaume DOTT <github@dott.fr>
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

<h3 class="dropdown">Log : <?php echo($logFile) ?>
<?php if(is_array($logFiles) && count($logFiles) > 1) : ?>
            <button class="btn dropdown-toggle" data-toggle="dropdown">
            <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
<?php foreach($logFiles as $file) : ?>
              <li><a href="<?php echo url_for('tools', 'log', $service, $file); ?>"><?php echo $file; ?></a></li>
<?php endforeach; ?>
            </ul>
<?php endif; ?>
</h3>
<div class="row">
	<!-- <div class="span12"><?php // echo($logSize) ?> Ko</div> -->
	<div class="span12">
		<?php foreach ($log as $logLine) { ?>
			<p><pre style="font-size: 11px"><?php echo $logLine ?></pre></p>
		<?php } ?>
	</div>
</div>

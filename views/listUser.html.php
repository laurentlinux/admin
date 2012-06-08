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
	<?php foreach ($users as $user) { ?>
		<div class="span6"> 
			<div class="well">
				<div class="row">
					<div class="avatar span2">
						<img src="<?php echo PUBLIC_DIR ?>/img/user.png" />
					</div>
					<div class="span">
						<?php foreach ($adminsDn as $adminDn) {
							if (preg_match('#^cn='.$user['cn'].'#', $adminDn)) { ?>
								<span class="label label-important">Admin</span>&nbsp;
						<?php }} ?>
						<a href="/user/update/<?php echo $user['uid']; ?>" title="<?php echo T_('Edit').' '.$user['uid'] ?>"
						style="color: inherit;"><strong><?php echo $user['uid']; ?></strong></a> 
							<span style="color: #999; font-size: 11px;">(<?php echo $user['cn']; ?>)</span>
						<div class="maillist"><?php echo $user['mail']; ?></div>
					</div>
					<div class="span1" style="margin-left: 3px; width: 55px; float: right;">
						<div style="text-align: right">
							<a href="/user/update/<?php echo $user['uid']; ?>" title="<?php echo T_('Edit').' '.$user['uid'] ?>" class="btn btn-smallest"><i class="icon-edit"></i></a>
							<a href="/user/delete/<?php echo $user['uid']; ?>" title="<?php echo T_('Delete').' '.$user['uid'] ?>" class="btn btn-smallest"><i class="icon-trash"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<div class="span6" style="text-align: center; padding-top: 10px;"> 
		<a class="btn btn-primary btn-large" href="/user/add"><i class="icon-plus icon-white" style="margin-top: 3px"></i> <?php echo T_('New user'); ?></a>
	</div>
</div>
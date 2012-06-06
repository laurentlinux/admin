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
         <div class="modal fade" id="welcomeModal">
          <div class="modal-header">
            <h2><?php echo T_('Congratulations !') ?></h2>
            </div>
            <div class="modal-body">
            <h4><?php echo T_('Yunohost has been succefully installed :-)') ?></h4>
            <br />
            <p><?php 

            $ip = exec('curl ifconfig.me');
            $domain = exec('hostname -d');

            echo T_('Now you have to:') ?>
            </p>
            <ol>
              <li><?php echo T_('Create the first user') ?></li>
              <li><?php echo T_('Configure your DNS entries with this:') ?>
              <div><pre>
@ 10800 IN A <?php echo $ip ?>

@ 10800 IN MX 10 mail.<?php echo $domain ?>.
<?php echo substr($domain, 0, strrpos($domain, '.')); ?> 10800 IN CNAME <?php echo $domain ?>.
admin 10800 IN CNAME <?php echo $domain ?>.
apps 10800 IN CNAME <?php echo $domain ?>.
auth 10800 IN CNAME <?php echo $domain ?>.
mail 10800 IN CNAME <?php echo $domain ?>.
www 10800 IN CNAME <?php echo $domain ?>.
_xmpp-server 28800 IN SRV 5 0 5269 <?php echo $domain ?>.
_jabber._tcp 28800 IN SRV 5 0 5269 <?php echo $domain ?>.
_xmpp-client._tcp 28800 IN SRV 5 0 5222</pre></div>
              </li>
              <li><a href="http://wiki.yunohost.org/Setup#DNS" title="<?php echo T_('Setup wiki') ?>"><?php echo T_('Configure your router') ?></a></li>
            </ol>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-primary" data-dismiss="modal"><?php echo T_('I got it!') ?></a>
          </div>
        </div>

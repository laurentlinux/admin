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
         <div class="modal fade" id="welcomeModal">
          <div class="modal-header">
            <h2><?php echo T_('Congratulations !') ?></h2>
          </div>
          <div class="modal-body">
            <div class="tabbable"> 
              <ul class="nav nav-tabs">
                <li class="active"><a href="#tab1" data-toggle="tab">Introduction</a></li>
                <li><a href="#tab2" data-toggle="tab">First user</a></li>
                <li><a href="#tab3" data-toggle="tab">DNS</a></li>
                <li><a href="#tab4" data-toggle="tab">Router</a></li>
                <li><a href="#tab5" data-toggle="tab">Help ?</a></li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane active" id="tab1">
                  <h4><?php echo T_('YunoHost has been succefully installed :-)') ?></h4>
                  <br />
                  <p><?php echo T_('Now you have to complete the 3 steps above, and you will be ready to go!') ?></p>

                  <hr />
                  <a href="#tab2" class="btn btn-primary pull-right btn-change-tab" data-toggle="tab"><?php echo T_('Next') ?><i class="icon-white icon-chevron-right" style="margin: 2px 0 0 6px"></i></a>
                  <div style="clear: both"></div>
                </div>
                <div class="tab-pane" id="tab2">
                  <h4><?php echo T_('Please create the first user') ?></h4>
                  <br />
                  <form action="/user/add" method="post" class="row-tab entityForm" id="ajaxAddUser">
                    <p class="row">
                      <label class="span2 labeluser" for="domain"><?php echo T_('Domain') ?> <span style="color: red">*</span></label>
                      <select class="span3" style="" type="text" name="domain" id="domain">
                      <?php $domain = exec('hostname -d'); ?>
                      <option value="<?php echo $domain ?>"><?php echo $domain ?></option>
                      </select> 
                    </p>
                    <p class="row">
                      <label class="span2 labeluser" for="username"><?php echo T_('Username') ?> <span style="color: red">*</span></label>
                      <input class="span3" type="text" name="username" id="username" required />
                    </p>
                    <p class="row">
                      <label class="span2 labeluser" for="password"><?php echo T_('Password') ?> <span style="color: red">*</span></label>
                      <input class="span3" type="password" name="password" id="password" required />
                    </p>
                    <p class="row">
                      <label class="span2 labeluser" for="confirm"><?php echo T_('Confirm password') ?> <span style="color: red">*</span></label>
                      <input class="span3" type="password" name="confirm" id="confirm" required />
                    </p>
                    <p class="row">
                      <label class="span2 labeluser" for="firstname"><?php echo T_('Firstname') ?> <span style="color: red">*</span></label>
                      <input class="span3" type="text" name="firstname" id="firstname" required />
                    </p>
                    <p class="row">
                      <label class="span2 labeluser" for="lastname"><?php echo T_('Lastname') ?> <span style="color: red">*</span></label>
                      <input class="span3" type="text" name="lastname" id="lastname" required />
                    </p>
                    <p class="row">
                      <label class="span2 labeluser" for="mail"><?php echo T_('Mail') ?> <span style="color: red">*</span></label>
                      <input class="span3" type="text" name="mail" id="mail" required />
                    </p>        
                    <p class="center"><input type="submit" value="<?php echo T_('Save user') ?>" class="btn btn-primary btn-submit"></p>
                    <div style="clear: both;"></div>
                    <hr />
                    <a href="#tab1" class="btn btn-primary pull-left btn-change-tab" data-toggle="tab"><i class="icon-white icon-chevron-left" style="margin: 2px 6px 0 0"></i><?php echo T_('Previous') ?></a>
                    <a href="#tab3" class="btn btn-primary pull-right btn-change-tab" data-toggle="tab" id="nextUser" style="display: none"><?php echo T_('Next') ?><i class="icon-white icon-chevron-right" style="margin: 2px 0 0 6px"></i></a>
                    <div style="clear: both"></div>
                  </form>
                </div>
                <div class="tab-pane" id="tab3">
                  <h4><?php echo T_('Configure your DNS entries like this:') ?></h4>
                  <br />
                  <?php $ip = file_get_contents('http://ip.yunohost.org'); ?>
                  <pre>
<?php echo $domain ?>          (<?php echo T_('type') ?> A)           <?php echo $ip ?>

admin.<?php echo $domain ?>    (<?php echo T_('type') ?> CNAME)       <?php echo $domain ?>

apps.<?php echo $domain ?>     (<?php echo T_('type') ?> CNAME)       <?php echo $domain ?>

auth.<?php echo $domain ?>     (<?php echo T_('type') ?> CNAME)       <?php echo $domain ?>

www.<?php echo $domain ?>      (<?php echo T_('type') ?> CNAME)       <?php echo $domain ?>

mail.<?php echo $domain ?>     (<?php echo T_('type') ?> CNAME)       <?php echo $domain ?>

<?php echo $domain ?>          (<?php echo T_('type') ?> MX)  (<?php echo T_('priority') ?> 10)  mail.<?php echo $domain ?> </pre>
                  <br />
                  <a href="http://wiki.yunohost.org/Setup#DNS"><?php echo T_('How to ?') ?></a>
                  <hr />
                  <a href="#tab2" class="btn btn-primary pull-left btn-change-tab" data-toggle="tab"><i class="icon-white icon-chevron-left" style="margin: 2px 6px 0 0"></i><?php echo T_('Previous') ?></a>
                  <a href="#tab4" class="btn btn-primary pull-right btn-change-tab" data-toggle="tab"><?php echo T_('Next') ?><i class="icon-white icon-chevron-right" style="margin: 2px 0 0 6px"></i></a>
                  <div style="clear: both"></div>
                </div>
                <div class="tab-pane" id="tab4">
                  <h4><?php echo T_('Configure your router') ?></h4>
                  <br />
                  <?php $localIP = exec('/sbin/ifconfig | sed \'/Bcast/!d\' | awk \'{print $2}\'| awk \'{print $2}\' FS=":"');
                        $macAddr = exec('/sbin/ifconfig | awk \'/HWaddr/ {print $5}\''); ?>
                  <p><?php echo T_('If you have any router (or box) to access the Internet, you have to follow these steps:') ?></p>
                  <ol>
                    <li><?php echo sprintf(T_('Fix your IP address (%s), to your MAC address (%s)'), '<strong>'.$localIP.'</strong>', '<strong>'.$macAddr.'</strong>') ?></li>
                    <li><?php echo T_('Open and redirect following ports to this IP address') ?> (<strong><?php echo $localIP ?></strong>) :
                      <p><strong>80, 443, 25, 5222, 5280, 5269, 993, 465</strong></p></li>
                    <li><?php echo T_('Deactivate SMTP lock if it is set') ?></li>
                  </ol>
                  <br />
                  <a href="http://wiki.yunohost.org/Category:Box"><?php echo T_('How to ?') ?></a>
                  <hr />
                  <a href="#tab3" class="btn btn-primary pull-left btn-change-tab" data-toggle="tab"><i class="icon-white icon-chevron-left" style="margin: 2px 6px 0 0"></i><?php echo T_('Previous') ?></a>
                  <a href="#tab5" class="btn btn-primary pull-right btn-change-tab" data-toggle="tab"><?php echo T_('Next') ?><i class="icon-white icon-chevron-right" style="margin: 2px 0 0 6px"></i></a>
                  <div style="clear: both"></div>
                </div>
                <div class="tab-pane" id="tab5">
                  <h4><?php echo T_("Don't worry, you will be able to reproduce these steps later.") ?></h4>
                  <br />
                  <p><?php echo T_('If you need some more informations, do not hesitate to:') ?></p>
                    <ul>
                      <li><a href="http://wiki.yunohost.org/Setup" target="_blank"><?php echo T_("Read the documentation") ?></li>
                      <li><a href="http://google.com" target="_blank"><?php echo T_("Make enquiries about self-hosting") ?></a></li>
                      <li><a href="/tools/chat" target="_blank"><?php echo T_("Activate the support chat to ask us") ?></li>
                    </ul>
                  <hr />
                  <a href="#tab4" class="btn btn-primary pull-left btn-change-tab" data-toggle="tab"><i class="icon-white icon-chevron-left" style="margin: 2px 6px 0 0"></i><?php echo T_('Previous') ?></a>
                  <a href="#" class="btn btn-success pull-right" data-dismiss="modal"><i class="icon-white icon-ok" style="margin: 2px 6px 0 0"></i><strong><?php echo T_('Finish') ?></strong></a>
                  <div style="clear: both"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

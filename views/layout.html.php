<?php 

 /**
  *  YunoHost - Self-hosting for all
  *  Copyright (C) 2012  Kload <kload@kload.fr>
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
<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?php echo $locale ?>"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>YunoHost <?php echo (isset($title)) ? "| ".$title : "" ?></title>
	<meta name="description" content="">
	<meta name="author" content="">

	<meta name="viewport" content="width=device-width">
  <!-- LESS for development -->
	<link rel="stylesheet/less" href="<?php echo PUBLIC_DIR ?>/less/style.less">
	<script src="<?php echo PUBLIC_DIR ?>/js/libs/less-1.2.1.min.js"></script>
  <!-- CSS for production -->
  <!-- <link media="all" type="text/css" href="<?php echo PUBLIC_DIR ?>/css/style.css" rel="stylesheet"> -->
	<script src="<?php echo PUBLIC_DIR ?>/js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>
</head>
<body class="gradient">
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="https://www.mozilla.org/firefox">install Firefox</a> to experience this site.</p><![endif]-->

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/"><img src="<?php echo PUBLIC_DIR ?>/img/logo.png"></a>
          <div class="nav-collapse">
            <ul class="nav pull-right">
              <li class="<?php echo ($tab == 'user') ? 'active' : '' ?>">
                <a href="/user/list"><i class="icon-user icon-white" style="margin: 2px 6px 0 0"></i><?php echo T_('Users') ?></a>
              </li>
              <li class="<?php echo ($tab == 'domain') ? 'active' : '' ?>">
                <a href="/domain/list"><i class="icon-globe icon-white" style="margin: 2px 6px 0 0"></i><?php echo T_('Domains') ?></a>
              </li>
              <li class="<?php echo ($tab == 'app') ? 'active' : '' ?>">
                <a href="/app/list"><i class="icon-leaf icon-white" style="margin: 2px 6px 0 0"></i><?php echo T_('Applications') ?></a>
              </li>
              <li class="dropdown <?php echo ($tab == 'tools') ? 'active' : '' ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="icon-wrench icon-white" style="margin: 2px 6px 0 0"></i><?php echo T_('Tools') ?>
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li><a href="/tools/monitor"><?php echo T_('System monitor') ?></a></li>
                  <li><a href="/tools/chat"><?php echo T_('Support chat') ?></a></li>
                  <li><a href="/tools/upgrade"><?php echo T_('Upgrade system') ?></a></li>
                </ul>
              </li>
              <li class="divider-vertical"></li>
              <li id="upgrade-li">
              <?php if (!isset($_SESSION['upgradeNumber'])) { ?>
                <a href="#" title="<?php echo T_('Check upgrades') ?>" style="color: #fff"><i class="icon-refresh icon-white" style="margin: 2px 0 0 0"></i></a>
              <?php } elseif ($_SESSION['upgradeNumber'] == 0) { ?>
                <a href="#" title="<?php echo T_('Your system is up-to-date') ?>" style="color: #fff"><i class="icon-ok icon-white" style="margin: 2px 0 0 0"></i></a>
              <?php } else { ?>
                <a href="/tools/upgrade" title="<?php echo T_('Upgrade') ?>" style="color: #fff"><i class="icon-download-alt icon-white" style="margin: 2px 6px 0 0"></i><span class="label label-info"><?php echo $_SESSION['upgradeNumber'] ?></span></a>
              <?php } ?>
              </li>
              <li class="divider-vertical"></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="icon-flag icon-white" style="margin: 2px 6px 0 0"></i>
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                  <li<?php if($locale == 'en') echo ' class="active"'; ?>><a href="<?php echo url_for('lang', 'en', array('redirect_to' => request_uri())); ?>"><?php echo T_('English') ?></a></li>
                  <li<?php if($locale == 'fr') echo ' class="active"'; ?>><a href="<?php echo url_for('lang', 'fr', array('redirect_to' => request_uri())); ?>"><?php echo T_('French') ?></a></li>
                </ul>
              </li>
              <li class="divider-vertical"></li>
              <li class="">
                <a href="/logout" title="<?php echo T_('Log out') ?>" style="color: #fff"><i class="icon-off icon-white" style="margin: 2px 6px 0 0"></i><strong><?php echo $userUid ?></strong></a>
              </li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

      <?php if (isset($_SESSION['first-install']) && $_SESSION['first-install']) { 
        include 'welcomePopUp.html.php';
      } ?>



      <ul class="breadcrumb">
        <li>
          <?php echo ($tab == 'user') ? '<a href="/user">'.T_('Users').'</a>' : '' ?> 
          <?php echo ($tab == 'domain') ? '<a href="/domain">'.T_('Domains').'</a>' : '' ?>
          <?php echo ($tab == 'app') ? '<a href="/app">'.T_('Applications').'</a>' : '' ?> 
          <?php echo ($tab == 'tools') ? '<a href="/tools">'.T_('Tools').'</a>' : '' ?> 
          <span class="divider">/</span>
        </li>
        <li class="active"><?php echo (isset($title)) ? $title : "" ?></li>
      </ul>


      <?php if (isset($flash['error'])) { ?>
        <div class="alert alert-error fade in">
          <a class="close" data-dismiss="alert">×</a>
          <strong><?php echo T_('Error') ?>:</strong> <?php echo $flash['error'] ?>
        </div>
      <?php } elseif (isset($flash['notice'])) { ?>
        <div class="alert fade in">
          <a class="close" data-dismiss="alert">×</a>
          <strong><?php echo T_('Notice') ?>:</strong> <?php echo $flash['notice'] ?>
        </div>
      <?php } elseif (isset($flash['success'])) { ?>
        <div class="alert alert-success fade in">
          <a class="close" data-dismiss="alert">×</a>
          <?php echo $flash['success'] ?>
        </div>
      <?php } ?>
      
      <?php echo $content?>
      <hr>

      <footer>
        <p><?php echo T_('Powered by') ?> <a href="http://yunohost.org/">YunoHost</a> (Beta)</p>
      </footer>

    </div> <!-- /container -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="<?php echo PUBLIC_DIR ?>/js/libs/jquery-1.7.1.min.js"><\/script>')</script>

<!-- scripts concatenated and minified via ant build script-->
<script src="<?php echo PUBLIC_DIR ?>/js/libs/bootstrap/transition.js"></script>
<script src="<?php echo PUBLIC_DIR ?>/js/libs/bootstrap/collapse.js"></script>
<script src="<?php echo PUBLIC_DIR ?>/js/libs/bootstrap/modal.js"></script>
<script src="<?php echo PUBLIC_DIR ?>/js/libs/bootstrap/dropdown.js"></script>
<script src="<?php echo PUBLIC_DIR ?>/js/libs/bootstrap/alert.js"></script>

<script src="<?php echo PUBLIC_DIR ?>/js/plugins.js"></script>
<script src="<?php echo PUBLIC_DIR ?>/js/script.js"></script>

<?php if (isset($_SESSION['chat'])) { ?>
  <script src="http://im.jappix.org/php/get.php?l=<?php echo $locale ?>&t=js&g=mini.xml" type="text/javascript"></script>
  <script type="text/javascript">
    jQuery(document).ready(function() {
      MINI_GROUPCHATS = ["support@conference.yunohost.org"];
      HOST_ANONYMOUS = "yunohost.org";
      HOST_MUC = "conference.yunohost.org";
      HOST_BOSH = "http://yunohost.org/http-bind/";
      LOCK_HOST = 'off';
      MINI_ANIMATE = true;
      MINI_ANONYMOUS = true;
      launchMini(false, true, 'yunohost.org');
    });
  </script>
<?php } ?>



<!-- end scripts-->
</body>
</html>

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
  

/**
 * GET /app
 */
function apps () {
  redirect_to('/app/list');
}

/**
 * GET /app/list
 */
function listApps () {
  $apps = shell_exec('yunohost check-apps');
  $apps = explode("\n", $apps);
  $appDesc = array();
  $appPkgNames = array();
  $installedApps = array();
  $appDirectories = array();

  $appDirectory = dirname(__FILE__).'/../../apps';

  $openDirectory = opendir($appDirectory);
  while($entry = @readdir($openDirectory)) {
    if(is_dir($appDirectory.'/'.$entry) && $entry != '.' && $entry != '..') {
        $appDirectories[] = $entry;
    }
  }
  closedir($openDirectory);

  foreach ($apps as $key => $app) {
    if (!empty($app)) {
      $appDesc[$key] = substr($app, strpos($app, ' - ') + 3);
      $appPkgNames[$key] = substr($app, 13, strpos($app, ' ') - 13);
      foreach ($appDirectories as $appDirectory) {
        if (preg_match('#'.$appDirectory.'$#', $appPkgNames[$key])) {
          $installedApps[$key] = $appDirectory;
        }
      }
    }
  }

  $upgradableApps = exec('yunohost upgradable-apps');
  $upgradableAppsArray = array_flip(explode("\n", $upgradableApps));

  set('upgradableApps', $upgradableAppsArray);
  set('installedApps', $installedApps);
  set('appDesc', $appDesc);
  set('appPkgNames', $appPkgNames);
  set('title', T_('List of applications'));
  return render("listApps.html.php");
}

/**
 * GET /app/:operation/:app
 */
function operateApp ($operation, $app) {

  $app = htmlspecialchars($app);
  $operation = htmlspecialchars($operation);
  $errorCode = 0;
  $trOperation = T_('Invalid operation');

  ob_start();
  switch ($operation) {
    case 'install':
      $trOperation = T_('Install');
      passthru('sudo yunohost install-app '.$app, $errorCode);
      break;

    case 'remove':
      $trOperation = T_('Remove');
      passthru('sudo yunohost remove-app '.$app, $errorCode);
      break;

    case 'update':
      $trOperation = T_('Update');
      passthru('sudo yunohost update-app '.$app, $errorCode);
      break;

    default:
      echo T_('Invalid operation');
      break;
  } 

  $result = ob_get_contents();
  ob_end_clean();

  $result = explode("\n", $result);

  set('result', $result);
  set('app', $app);
  set('errorCode', $errorCode);
  set('title', $trOperation.' '.ucfirst($app));
  return render("appOperation.html.php");
}
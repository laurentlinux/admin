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
 * GET /tools/log/:logFile
 */
function watchLog ($logFile = null) {
  if(empty($logFile)) halt(NOT_FOUND, "Undefined name.");

  switch ($logFile) {
    case 'apache-admin':
      $logFile = '/var/log/apache2/admin-error.log';
      //$logFile = '/var/log/apache2/admin-error.log';
      break;
    
    case 'apache-im':
      $logFile = '/var/log/apache2/im-error.log';
      break;
    
    default:
      $logFile = '/tmp/yayaya';
      break;
  }

  $log = read_file($logFile, 10);
  set('title', T_('Log reader'));
  set('log', $log);
  set('logFile', $logFile);
  set('logSize', round(filesize($logFile)/1024,2));
  return render("log.html.php"); 
}

/**
 * GET /tools/chat
 */
function getChat () {
  set('title', T_('Chat'));
  return render("chat.html.php"); 
}

/**
 * GET /tools/chat/enable
 */
function enableChat () {
  if (!isset($_SESSION['chat'])) {
    $_SESSION['chat'] = true;
    flash('success', T_('The support chat has been enabled.'));
  }
  redirect_to('/tools/chat');
}

/**
 * GET /tools/chat/disable
 */
function disableChat () {
  if (isset($_SESSION['chat'])) {
    unset($_SESSION['chat']);
    flash('success', T_('The support chat has been disabled.'));
  }
  redirect_to('/tools/chat');
}

/**
 * GET /tools/monitor
 */
function tools () {
  redirect_to('/tools/monitor');
}

/**
 * GET /tools/monitor
 */
function systemMonitor () {

  function checkPort($port) {
    $conn = @fsockopen("127.0.0.1", $port, $errno, $errstr, 0.2);
    if ($conn) {
      fclose($conn);
      return true;
    }
  }
  $report = array();
  $svcs = array('22'=>'SSH',
                '25'=>'SMTP',
                '80'=>'HTTP',
                '143'=>'IMAP',
                '3306'=>'MySQL');
  foreach ($svcs as $port=>$service) {
    $report[$service] = checkPort($port);
  }

  $globalIP = exec('curl ifconfig.me');
  $localIP = exec('/sbin/ifconfig | sed \'/Bcast/!d\' | awk \'{print $2}\'| awk \'{print $2}\' FS=":"');
  $macAddr = exec('/sbin/ifconfig | awk \'/HWaddr/ {print $5}\'');
  exec('/usr/bin/top -b -n 1 -i', $top);

  $summary = preg_split('/, /', substr($top[0], strpos($top[0], '-') + 2));
  $time = substr($summary[0], 0, strpos($summary[0], ' '));
  $uptime = substr($summary[0], strpos($summary[0], 'up ') + 3);
  $tasks = preg_split('/ [a-z]+[, ]?/', substr($top[1], strpos($top[1], ':') + 2));
  $cpu = preg_split('/%[a-z]{2}[, ]?/', substr($top[2], strpos($top[2], ':') + 2));
  $mem = preg_split('/k [a-z]+[, ]?/', substr($top[3], strpos($top[3], ':') + 2));
  $swap = preg_split('/k [a-z]+[, ]?/', substr($top[4], strpos($top[4], ':') + 2));

  set('globalIP', $globalIP);
  set('localIP', $localIP);
  set('macAddr', $macAddr);
  set('report', $report);
  set('summary', $summary);
  set('time', $time);
  set('uptime', $uptime);
  set('tasks', $tasks);
  set('cpu', $cpu);
  set('memory', $mem);
  set('swap', $swap);
  set('processes', $uptime);

  set('title', T_('System monitor'));
  return render("systemMonitor.html.php");
}

/**
 * GET /tools/upgrade/number (AJAX access only)
 */
function getUpgradeNumber () {
  exec('sudo yunohost check-repo');
  $number = exec('sudo yunohost upgradable-pkgs');
  $_SESSION['upgradeNumber'] = $number;

  return $number;
}


/**
 * GET /tools/upgrade
 */
function upgradeConfirm () {
  if (!isset($_SESSION['upgradeNumber'])) {
    exec('sudo yunohost check-repo');
    $number = exec('sudo yunohost upgradable-pkgs');
    $_SESSION['upgradeNumber'] = $number;
  }

  set('number', $_SESSION['upgradeNumber']);
  set('title', T_('System upgrade'));
  return render("upgradeConfirm.html.php");
}


/**
 * GET /tools/upgrade/packages (AJAX access only)
 */
function upgradeAjax () {
  ob_start();
  passthru('sudo yunohost update-dist' , $errorCode);
  $result = ob_get_contents();
  ob_end_clean();

  $result = str_replace("\n", "<br />", $result);
  if ($errorCode) $_SESSION['upgradeNumber'] = 0;
  return $result;
}
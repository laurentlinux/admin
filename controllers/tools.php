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
 * GET /tools/log/:service
 */
function watchLog ($service = null) {
  if(empty($service)) halt(NOT_FOUND, T_('Undefined service.'));

  switch ($service) {
    case 'HTTP':
      $logFile = '/var/log/apache2/error.log';
      break;
    
    case 'XMPP':
      $logFile = '/var/log/ejabberd/ejabberd.log';
      break;

    case 'SSH':
      $logFile = '/var/log/auth.log';
      break;
    
    case 'Mail':
      $logFile = '/var/log/mail.err';
      break;

    case 'MySQL':
      $logFile = '/var/log/mysql.err';
      break;
    
    case 'FTP':
      $logFile = '/var/log/proftpd/proftpd.log';
      break;  

    // case 'Radicale':
    //   $logFile = '/var/log/?';
    //   break;
    
    default:
      $logFile = false;
      // $logFile = false;
      break;
  }

  if ($logFile) {
    exec('sudo yunohost cp-log '.$logFile);
    $log = read_file('/tmp/readlog', 10);
    // $logSize = round(filesize($logFile)/1024,2);
    exec('sudo yunohost remove-log');
  } else {
    $log = array(T_('There is no log file for this service.'));
  }

  set('title', T_('Log reader'));
  set('log', $log);
  set('logFile', $logFile);
  // set('logSize', $logSize);
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
  $svcs = array('80'=>'HTTP',
                '22'=>'SSH',
                '25'=>'Mail',
                '5269' => 'XMPP',
                '3306'=>'MySQL',
                '21'=>'FTP',
                '5232'=>'Radicale',
                );
  foreach ($svcs as $port=>$service) {
    $report[$service] = checkPort($port);
  }

  $services = array(
      'SSH' => 'ssh',
      'Mail' => 'postfix',
      'XMPP' => 'ejabberd',
      'MySQL' => 'mysqld',
      'FTP' => 'proftpd',
      'Radicale' => 'radicale'
    );

  $globalIP = file_get_contents('http://ip.yunohost.org');
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
  set('services', $services);
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
 * GET /tools/monitor
 */
function tasksManager() {
  function ps_explode($line) {
    return explode(" ", $line, 11);
  }

  exec("ps aux | tr -s ' '", $tasks);
  $tasks = array_map('ps_explode', $tasks);

  set('tasks_head', array_shift($tasks));
  set('tasks', $tasks);

  set('title', T_('Tasks manager'));
  return render("tasksManager.html.php");
}

/**
 * GET /tools/upgrade/number (AJAX access only)
 */
function getUpgradeNumber () {
  exec('sudo yunohost check-repo');
  $number = exec('sudo yunohost upgradable-pkgs');
  $_SESSION['upgradeNumber'] = $number;

  if ($number) {
    $html =   '<a href="/tools/upgrade" title="'.T_('You have updates on your system').'" style="color: #fff">
                <i class="icon-download-alt icon-white" style="margin: 2px 6px 0 0"></i>
                <span class="label label-info">'.$number.'</span>
                 <span class="tiptool alert alert-info" style="display: none; padding: 1px 5px 3px; margin-left: 5px;">'.T_('You have updates on your system').'</span>
              </a>';
  } else {
    $html =   '<a href="#" title="'.T_('Your system is up-to-date').'" style="color: #fff">
                <i class="icon-ok icon-white" style="margin: 2px 0 0 0"></i>
                <span class="tiptool alert alert-success" style="display: none; padding: 1px 5px 3px; margin-left: 5px;">'.T_('Your system is up-to-date').'</span>
              </a>';
  }

  return $html;
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

/**
 * GET /tools/activate/:service
 */
function activateService ($service) {
  $service = htmlspecialchars($service);
  if (!preg_match('/\s/', $service)) {
    exec('sudo yunohost enable-service '.$service, $out2, $code2);
    exec('sudo yunohost start-service '.$service, $out1, $code1);
    if (!$code1 && !$code2)
      flash('success', $service.' '.T_('succefully enabled.'));
    else
      flash('error', $out1."\n".$out2);
  }
  redirect_to('/tools/monitor');
}

/**
 * GET /tools/deactivate/:service
 */
function deactivateService ($service) {
  $service = htmlspecialchars($service);
  if (!preg_match('/\s/', $service)) {
    exec('sudo yunohost disable-service '.$service, $out2, $code2);
    exec('sudo yunohost stop-service '.$service, $out1, $code1);
    if (!$code1 && !$code2)
      flash('success', $service.' '.T_('succefully disabled.'));
    else
      flash('error', $out1."\n".$out2);
  } else flash('error', T_('Invalid service name.'));
  redirect_to('/tools/monitor');
}

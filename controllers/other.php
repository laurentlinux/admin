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
  

/**
 * GET /
 */
function home() {
  redirect_to('/user/list');
}

/**
 * GET /logout
 */
function logout() {
  header('WWW-Authenticate: Basic realm="Restricted administration"');
  header('HTTP/1.0 401 Unauthorized');
  echo T_('You must identify yourself to access to this page.');
  exit;
}

/**
 * GET /lang/:locale
 */
function changeLocale ($locale = 'en') {
  switch ($locale) {
    case 'fr':
      $_SESSION['locale'] = 'fr';
      break;
    
    default:
      $_SESSION['locale'] = 'en';
      break;
  }
  redirect_to('/user/list');
}

/**
 * GET /images/:name/:size
 */
function image_show()
  {
    $ext = file_extension(params('name'));
    $filename = option('public_dir').basename(params('name'), ".$ext");
    if(params('size') == 'thumb') $filename .= ".thb";
    $filename .= '.jpg';
    
    if(!file_exists($filename)) halt(NOT_FOUND, "$filename doesn't exists");
    render_file($filename);
  }

/**
 * GET /images/*.jpg/:size
 */
function image_show_jpeg_only()
  {
    $ext = file_extension(params(0));
    $filename = option('public_dir').params(0);
    if(params('size') == 'thumb') $filename .= ".thb";
    $filename .= '.jpg';
  
    if(!file_exists($filename)) halt(NOT_FOUND, "$filename doesn't exists");
    render_file($filename);
  }
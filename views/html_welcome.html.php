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
<h3>Hello <?php print_r($name)?>!</h3>
<p><a href="<?php echo url_for('/how_are_you/', $name)?>">How are you <?php echo $name?>?</a></p>
<hr>
<p><a href="<?php echo url_for('/images/soda_glass.jpg')?>">
   <img src="<?php echo url_for('/soda_glass.jpg/thumb')?>"></a></p>
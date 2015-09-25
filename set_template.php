<?php
/*
	Alibumbum - Web application to create your personal photo album
    Copyright (C) 2006 by Phu Hiep DUONG <duongphuhiep@hotmail.com>

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
    
    Version: 1.0
    
    Other authors: <none>
*/


	/*
	This script is to change the current template, it takes 2 parameters for $_GET
	tpl = name of the template
	moveto = page to move to after changing
	Exemple:  set_template.php?tpl=phpalbum&moveto=index.php
	*/
    require('config.php');
	
	if (array_key_exists('tpl',$_GET)) {
		$tmp = $_GET["tpl"];
		if (is_dir(TEMPLATES_DIR.$tmp))
			setcookie("template", $tmp);
	}
	/*
	if (isset($_GET["moveto"])) {
		header("Location:".urldecode($_GET["moveto"]));
	} else {
		header("Location:index.php");
	}
	*/
	header("Location:index.php");
	exit();
?>

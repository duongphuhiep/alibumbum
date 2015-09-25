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

	require("cache.php");
	
	$idcomment = urldecode($_GET["id"]);
	deleteComment($idcomment);
	increaseViewTime($page,-1); // we have to decrease the time view here, because when we return to index, the time view'll be back to normal
	header("Location: index.php?page=".getPathToPhotoFromIDComment($idcomment));
	exit();
?>
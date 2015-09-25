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


	/**
	 * this script will re-create all resized images of an specify original image.
	 * parameter:
	 * 	photo: name to image which need to update
	 * 	force: =true:   re-create resized image
	 *         =false:  do nothing if resized image has already exists
	 *  moveto:	address to move to after updating
	 * 
	 * Eg:
	 *   update.php?photo=album/hiep.jpg&force=true&moveto=index.php  => update album/hiep.jpg then return to home page
	 * 
	 * In fact we always use this script to update images one by one. But you can also do:
	 *   update.php?force=true&moveto=index.php  => update all image (for the current template) then return to home page
	 *   update.php?force=false&moveto=index.php => full the cache then return to home page (don't update resized image that have already in the cache)
	 */

	require("cache.php");
	
	@set_time_limit(0); // no time limit
	
	$force = $_GET["force"];
	$photo = $_GET["photo"];
	$moveto = $_GET["moveto"];
	
	if ($force=="true") $force = true; else $force = false;
	
	// update
	
	if (isset($photo)) {
		$photo = urldecode($photo);
		if (!isImageFile($photo)) {
			echo "Error: $photo is not a valid photo";
		}
		else {
			$hc	= opendir(CACHE_DIR);
			while ($sz = readdir($hc)) {
				if ($sz!="." && $sz!="..") { // $sz = "100" "120" "640" "720"...
					$size = (int)$sz; // $size = 100 120 640 720...
					getResizedPhoto($photo,$size,$force);
				}
			}
			closedir($hc);
		}
	}
	else {
		
		// update all
				
		$hg	= opendir(PHOTOS_DIR);
		while ($group = readdir($hg)) {
			if ($group!="." && $group!="..") {
				$hp = opendir(PHOTOS_DIR.$group);
				while ($photo = readdir($hp)) {
					if ($photo!="." && $photo!="..") {
						getResizedPhoto($group."/".$photo,$VIEW_SIZE,$force)."<br>";
						getResizedPhoto($group."/".$photo,$THUMBS_SIZE,$force)."<br>";
					}
				}
				closedir($hp);
			}
		}
		closedir($hg);
		sleep(3);
	}
	
	// move to other page
	
	if (isset($moveto))
		header("Location:".urldecode($moveto));
	else 
		header("Location:index.php");
?>
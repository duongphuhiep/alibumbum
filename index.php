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
    
    Version: 1.01
    
    Other authors: <none>
*/


	/**
	 * Convention of prefix "h_" and "p_" in the code:
	 * 	h_index is handle of index.tpl
	 * 	p_index is the index page after compiling
	 */
	require("template.inc");
	require("config.php");
	require("cache.php");
	
	// determine a template to use and read its configuration
	// the template is determined by the a cookie variable called 'template'
	
    global $CURRENT_TEMPLATE;
    
	if (array_key_exists('template',$_COOKIE)) {
		$tmp = TEMPLATES_DIR.$_COOKIE["template"]."/";
		if ($CURRENT_TEMPLATE != $tmp) { 
			// you ve change the template => reload the new template
			$CURRENT_TEMPLATE = $tmp;
			$configtpl=fopen($CURRENT_TEMPLATE."config.txt","r");
			$MAX_ROWS = (int)fgets($configtpl); 
			$MAX_COLS = (int)fgets($configtpl);
			$THUMBS_SIZE = (int)fgets($configtpl);
			$VIEW_SIZE = (int)fgets($configtpl);
			$MOST_VIEW_PHOTOS = (int)fgets($configtpl);
			$RANDOM_PHOTOS = (int)fgets($configtpl);
			fclose($configtpl);
		}
	}
	else { 
		// using default template
		$CURRENT_TEMPLATE = TEMPLATES_DIR.DEFAULT_TEMPLATE."/";
		$configtpl=fopen($CURRENT_TEMPLATE."config.txt","r");
		$MAX_ROWS = (int)fgets($configtpl); 
		$MAX_COLS = (int)fgets($configtpl);
		$THUMBS_SIZE = (int)fgets($configtpl);
		$VIEW_SIZE = (int)fgets($configtpl);
		$MOST_VIEW_PHOTOS = (int)fgets($configtpl);
		$RANDOM_PHOTOS = (int)fgets($configtpl);
		fclose($configtpl);
	}
	
	$RESIZING_DIR		=	CACHE_DIR.strval($VIEW_SIZE);
	$THUMBS_DIR			=	CACHE_DIR.strval($THUMBS_SIZE);

	// display templates...
		
    if  (array_key_exists('page', $_GET))
	    $page = $_GET["page"];
    else
	    $page="home";
	$fullURLencode = urlencode("http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?{$_SERVER['QUERY_STRING']}"); // get the current URL of the page after encoding
	
	$t = new Template($CURRENT_TEMPLATE);
	
	$t->set_file(array(
		"h_index" => "index.tpl",
		"h_welcome" => "welcome.tpl",
		"h_photoview" => "photoview.tpl",
	));

	// compile statistics info
	
	$tmp = getStatistic();
	$t->set_var(array(
		"nb_photos" => $tmp[0],
		"nb_groups" => $tmp[1],
		"album_size" => number_format((double)$tmp[2]/1048576,2),
		"nb_comments" => countComments()
	));
		
	// compile index.tpl/group is the list of all group
	
	$t->set_block("h_index","group","groups");
	$groups = getGroups();
	foreach ($groups as $group) {
		$t->set_var(array(
			"group_name" => $group,
			"link_to_group" => "index.php?page=".urlencode($group),
			"nb_photos_of_group" => countPhotosInGroup($group)
		));
		
		$t->parse("groups","group",true);
	}
	
	// compile index.tpl/main is the main content of page
	
	if ($page == "home") { // in this case: the main content is welcome page
		// compile welcome page
		
		// display random photos:
		
		$t->set_block("h_welcome","thumb2","thumbs2");
		$photos = getRandomPhotos($RANDOM_PHOTOS);

        if (count($photos)<$RANDOM_PHOTOS) 
            $RANDOM_PHOTOS = count($photos);
		$j=0; // this variable use to know whenever we insert the <tr> and </tr> in the template
		for ($i=0; $i<$RANDOM_PHOTOS; $i++) {
			list($group,$image_name) = explode("/",$photos[$i]);
			$tmp = urlencode($photos[$i]);
			list($imgWidth, $imgHeight) = getPhotoSize($photos[$i], $THUMBS_SIZE);
			$t->set_var(array(
				"update_link" => "update.php?photo=".$tmp."&force=true&moveto=".$fullURLencode,
				"cell_link" => "index.php?page=".$tmp,
				"thumb_path" => getResizedPhoto($photos[$i],$THUMBS_SIZE),
				"thumbs_size" => $THUMBS_SIZE,
				"image_name" => $image_name,
				"vt" => getViewTime($photos[$i]),
				"cm" => count(getComments($photos[$i])),
				"img_width" => $imgWidth,
				"img_height" => $imgHeight
			));
			$j++;
			if ($j==1) {
				$tmp=$t->get_var("thumbs2");
				$t->set_var("thumbs2","<tr>".$tmp);
			} 
			$t->parse("thumbs2","thumb2",true);
			if ($j==$MAX_COLS) {
				$tmp=$t->get_var("thumbs2");
				$t->set_var("thumbs2",$tmp."</tr>");
				$j=0;
			}
		}
		
		// display most view photos:
		
		$t->set_block("h_welcome","thumb","thumbs");
		$photos = getAllPhotos();
        if (count($photos)<$MOST_VIEW_PHOTOS) $MOST_VIEW_PHOTOS = count($photos);
        
		$j=0; // this variable use to know whenever we insert the <tr> and </tr> in the template
		for ($i=0; $i<$MOST_VIEW_PHOTOS; $i++) {
			list($group,$image_name) = explode("/",$photos[$i]);
			$tmp = urlencode($photos[$i]);
			list($imgWidth, $imgHeight) = getPhotoSize($photos[$i], $THUMBS_SIZE);
			$t->set_var(array(
				"update_link" => "update.php?photo=".$tmp."&force=true&moveto=".$fullURLencode,
				"cell_link" => "index.php?page=".$tmp,
				"thumb_path" => getResizedPhoto($photos[$i],$THUMBS_SIZE),
				"thumbs_size" => $THUMBS_SIZE,
				"image_name" => $image_name,
				"vt" => getViewTime($photos[$i]),
				"cm" => count(getComments($photos[$i])),
				"img_width" => $imgWidth,
				"img_height" => $imgHeight
			));
			$j++;
			if ($j==1) {
				$tmp=$t->get_var("thumbs");
				$t->set_var("thumbs","<tr>".$tmp);
			} 
			$t->parse("thumbs","thumb",true);
			if ($j==$MAX_COLS) {
				$tmp=$t->get_var("thumbs");
				$t->set_var("thumbs",$tmp."</tr>");
				$j=0;
			}
		}
		if ($j<$MAX_COLS) {
			$tmp=$t->get_var("thumbs");
			$t->set_var("thumbs",$tmp."</tr>");
		}
		
		$t->parse("p_welcome","h_welcome");
		$t->set_block("h_index","main","p_welcome");
	} else { 
		
		// in this case: the main content is group page (thumbs page) or photo page (for resized photo)

		$page = urldecode($page);
		
		if (!isGroup($page) && !isImageFile($page)) {
			// the page is not valid
			echo "Error: the page don't exists! <a href=\"index.php\"> Return to home page</a>";
			exit();
		}
		
		list($group,$image)=explode("/",$page);
		$photos = getPhotos($group);
		
		if (!isset($image)) {  
			
			// compile group page (display all thumbs)...
			
			$t->set_block("h_index","thumb","thumbs");
			
			$pagenum = $_GET["pagenum"];
			if (!isset($pagenum)) $pagenum = 1;
			
			// display thumbs from $istart to $iend
			
			$istart = $MAX_COLS * $MAX_ROWS * ($pagenum-1);
			$tmp1 = $MAX_COLS * $MAX_ROWS * $pagenum-1;
			$tmp2 = count($photos)-1;
			$iend = $tmp1<$tmp2?$tmp1:$tmp2;
			
			$j=0; // this variable use to know whenever we insert the <tr> and </tr> in the template
			for ($i=$istart; $i<=$iend; $i++) {
				list($group,$image_name) = explode("/",$photos[$i]);
				$tmp = urlencode($photos[$i]);
				list($imgWidth, $imgHeight) = getPhotoSize($photos[$i], $THUMBS_SIZE);
				$t->set_var(array(
					"update_link" => "update.php?photo=".$tmp."&force=true&moveto=".$fullURLencode,
					"cell_link" => "index.php?page=".$tmp,
					"thumb_path" => getResizedPhoto($photos[$i],$THUMBS_SIZE),
					"thumbs_size" => $THUMBS_SIZE,
					"image_name" => $image_name,
					"vt" => getViewTime($photos[$i]),
					"cm" => count(getComments($photos[$i])),
					"img_width" => $imgWidth,
					"img_height" => $imgHeight
				));
				$j++;
				if ($j==1) {
					$tmp=$t->get_var("thumbs");
					$t->set_var("thumbs","<tr>".$tmp);
				} 
				$t->parse("thumbs","thumb",true);
				if ($j==$MAX_COLS) {
					$tmp=$t->get_var("thumbs");
					$t->set_var("thumbs",$tmp."</tr>");
					$j=0;
				}
			}
			if ($j<$MAX_COLS) {
				$tmp=$t->get_var("thumbs");
				$t->set_var("thumbs",$tmp."</tr>");
			}
			
			// compile pagenum bar of the thumbs page
			
			$tmp1 = count($photos);
			$tmp2 = $MAX_COLS*$MAX_ROWS;
			$pagecount = (int)($tmp1/$tmp2 + (($tmp1%$tmp2==0)?0:1));
			if ($pagecount==0) $pagecount=1;
			
			$t->set_var(
				array(
					"group_name" => $group,
					"photo_name_no_ext" => "",
					"first_link" => ($pagenum!=1) ? "index.php?page=".$group : "javascript:nolink()",
					"prev_link" => ($pagenum>1) ? "index.php?page=".$group."&pagenum=".($pagenum-1) : "javascript:nolink()",
					"next_link" => ($pagenum<$pagecount) ? "index.php?page=".$group."&pagenum=".($pagenum+1) : "javascript:nolink()",
					"last_link" => ($pagenum!=$pagecount) ? "index.php?page=".$group."&pagenum=".$pagecount : "javascript:nolink()",
					"page_num" => $pagenum,
					"page_count" => $pagecount)
			);
			
		} else { 
			
			// compile photoview.tpl (display an image)...
			
			increaseViewTime($page,1);
			$pathToResizedPhoto = getResizedPhoto($page,$VIEW_SIZE);
			list($imgWidth, $imgHeight) = getPhotoSize($page, $VIEW_SIZE);
			
			$t->set_var(array(
				"original_photo_url" => PHOTOS_DIR.$page,
				"resized_photo_url" => $pathToResizedPhoto,
				"photo_name_no_ext" => basename($pathToResizedPhoto,".jpg"),
				"vt" => getViewTime($page),
				"cm" => count(getComments($page)),
				"img_width" => $imgWidth,
				"img_height" => $imgHeight
			));
			
			// compile pagenum bar of the view page
			
			$pagecount = count($photos);
			$tmp = array_keys($photos,$page);
			$pagenum = $tmp[0]+1;
			
			$t->set_var(array(
				"group_name" => $group,
				"photo_name_with_ext" => $image,
				"first_link" => ($pagenum!=1) ? "index.php?page=".urlencode($photos[0]) : "javascript:nolink()",
				"prev_link" => ($pagenum>1) ? "index.php?page=".urlencode($photos[$pagenum-2]) : "javascript:nolink()",
				"next_link" => ($pagenum<$pagecount) ? "index.php?page=".urlencode($photos[$pagenum]) : "javascript:nolink()",
				"last_link" => ($pagenum!=$pagecount) ? "index.php?page=".urlencode($photos[$pagecount-1]) : "javascript:nolink()",
				"page_num" => $pagenum,
				"page_count" => $pagecount
			));
			
			// compile comment_part of photoview.tpl
			
			$t->set_var("photo_url", urlencode($page));
			
			$comments = getComments($page);
			if (count($comments)==0) { // if there are any comments
				$t->set_block("h_photoview","all_comment","empty");
			} else {
				$t->set_block("h_photoview","comment","comments");
				foreach ($comments as $comment) {
					$t->set_var(array(
						"email" => $comment->email,
						"name" => $comment->name,
						"time" =>  date("d M Y, H:m", $comment->time),
						"message" => $comment->text,
						"comment_id" => urlencode($comment->getID()),
						"comment_ip" => $comment->ip
					));
					$t->parse("comments","comment",true);
				}
			}
			
			// compile photoview.tpl
			
			$t->parse("p_photoview","h_photoview");
			$t->set_block("h_index","index","p_photoview");
		}
	}
	
	// the variables are always needed (for all page)
	
	$t->set_var(array(
		"tpl" => $CURRENT_TEMPLATE,		// current template directory
		"encurl" => $fullURLencode	// current url after encoding
	));
	
	// compile index
	
	$t->pparse("p_index","h_index");
?>
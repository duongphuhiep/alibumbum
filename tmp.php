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

//******************************
// manage caching photos
//******************************

/**
 * Verify if a .jpg caching file is trashy, trashy file don't have equivalent image in the photos directory.
 * Eg: $cachingFile = "cache/720/Photo2006/mydogs.jpg" is trashy if any of photos/Photo2006/mydogs.* exists
 *
 * @param String $cachingFile A file in cache directory
 * @return true if $cachingFile is trash
 */
function isTrash($cachingFile) {
	list($pathNoExt, $ext) = explode(".",$cachingFile);
	$img_name = basename($cachingFile, ".".$ext);
	$group_name = basename(dirname($cachingFile));

	if ($dh	= @opendir(PHOTOS_DIR.$group_name)) {
		while ($entry = readdir($dh)) {
			if ($entry!="." && $entry!="..") {
				list($img_name2, $ext2) = explode(".",$entry);
				if ($img_name==$img_name2)
					return false;
			}
		}
		closedir($dh);
	}
	return true;
	//return (count(glob(PHOTOS_DIR.$group_name."/".$img_name.".*"))==0);
}


/**
 * Remove recursively all caching file in a $root directory. Removed files are displayed
 * $root must to be termined by "/".
 * To clean all trashy catching file, we call cleanInCache(CACHE_DIR);
 *
 * @param String $root
 */
function cleanInCache($root) {
	$dh	= opendir($root);
	while ($entry = readdir($dh)) {
		if ($entry!="." && $entry!="..") {
			$fullpath = $root.$entry;
			if (is_dir($fullpath)) {
				cleanInCache($fullpath."/");
			}
			else if (isTrash($fullpath)) {
				unlink($fullpath);
				echo $fullpath." was removed<br>";
			}
		}
	}
	closedir($dh);
}

/**
 * Remove a directory if it's empty. Otherwise, do the same things with all sub-directory
 *
 * @param unknown_type $root
 */
function rmdir2($root) {
	// root is often a sub-directory of "cache" like "vt", "720"..
	$dh	= opendir($root);
	while ($entry = readdir($dh)) {
		if ($entry!="." && $entry!="..") {
			$fullpath = $root.$entry."/";
			if (is_dir($fullpath)) {
				rmdir2($fullpath);
			}
		}
	}
	closedir($dh);
	@rmdir($root);
}

/**
 * Delete all empty directory in a directory $dir. Removed directories are displayed
 * Eg: cleanAllEmptyDir("cache/")
 */
function cleanAllEmptyDir($dir) {
	$dh	= opendir($dir);
	while ($entry = readdir($dh)) {
		if ($entry!="." && $entry!="..") {
			$fullpath = $dir.$entry."/";
			if (is_dir($fullpath)) {
				rmdir2($fullpath);
			}
		}
	}
	closedir($dh);
}


//******************************
// manage view time file
//******************************

/**
 * get the equivalent VT file of a photo (file .vt)
 * @param		$pathToPhoto	A string represent the photo. Eg: "Photo2006/myfamily.jpg"
 * @return		the path to the equivalent VT file. Eg: "cache/vt/Photo2006/myfamily.vt"
 */
function getViewTimeFile($pathToPhoto) {
	list($fd,$ext) = split("\.",$pathToPhoto,2);
	$resu = VT_DIR.$fd.".vt";

	// create equivalent .vt file
	if (!file_exists($resu)) {
		mkdir2(dirname($resu),0777);
		$f = fopen($resu,"w");
		fwrite($f,"0");
		fclose($f);
	}
	return $resu;
}

function getViewTime($pathToPhoto) {
	$f = fopen(getViewTimeFile($pathToPhoto),"r");
	$arr = fscanf($f,"%d");
	fclose($f);
	return $arr[0];
}

/**
 * Increase time of view a photo to $t times
 *
 * @param String $pathToPhoto
 * @param String $t	time of view to increase (normally 1)
 */
function increaseViewTime($pathToPhoto, $t=1) {
	$vtfile = getViewTimeFile($pathToPhoto);
	// read old value
	$f = fopen($vtfile,"r");
	$arr = fscanf($f,"%d");
	$viewtime = $arr[0];
	fclose($f);
	// increase this value
	$viewtime+=$t;
	// save the new value
	$f = fopen($vtfile,"w");
	fwrite($f,$viewtime);
	fclose($f);
}

/**
 * Return true if $f is a name of image's file and this image existes in the PHOTOS_DIR<br>
 * Eg:
 *   isImageFile("Huong's house/hiep.jpg") return true if the file "photos/Huong's house/hiep.jpg" exists
 *   isImageFile("Huong's house/bambou.avi") always return false.
 * @param String $f
 * @return boolean
 */
function isImageFile($f) {
	if (!file_exists(PHOTOS_DIR.$f)) return false;
	$t=strtoupper(substr($f,-3,3));
	$t2=strtoupper(substr($f,-4,4));
	if($t=="GIF" ||$t=="PNG" ||$t=="JPG" ||$t2=="JPEG") return true;
	return false;
}

function hasImageExtension($f) {
	$t=strtoupper(substr($f,-3,3));
	$t2=strtoupper(substr($f,-4,4));
	if($t=="GIF" ||$t=="PNG" ||$t=="JPG" ||$t2=="JPEG") return true;
	return false;
}

/**
 * Return true if $group is a name of group in the PHOTOS_DIR
 *
 * @param unknown_type $group
 * @return unknown
 */
function isGroup($group) {
	return (!strpos("/",$group)) && is_dir(PHOTOS_DIR.$group);
}

/**
 * make recursively a directory like commande mk -p of Linux
 *
 * @param String $dir a path
 * @param $mode
 * @return true if successful or the directory have already existes.
 */
function mkdir2($dir, $mode = 0755) {
	if (is_dir($dir) || @mkdir($dir,$mode)) return TRUE;
	if (!mkdir2(dirname($dir),$mode)) return FALSE;
	return @mkdir($dir,$mode);
}

//******************************
// traitement d'image
//******************************

/**
 * Get a resized photo of a $maxDimension in the cache. Eg:
 * getResizePhoto("Photo2006/hiep.jpg",720) will return
 * image file: cache/720/Photo2006/hiep.jpg
 * this photo take 720 as a maximum dimension. This function creates
 * the resized photo if it's not exists, or re-create (update) the resized photo
 * with option $force= true
 *
 * Note: All image in the cache is jpg image, and the "jpg" extension is in lower case
 * this function works only for .gif, .png and .jpg images
 *
 * @param String $pathToPhoto
 * @param String $maxDimension
 * @param boolean $force
 * @return path to the resized photo
 */
 
define('MAX_BYTES_ALLOC', 33554432);
define('ERROR_IMAGE', TEMPLATES_DIR."/error.gif");
 
function getResizedPhoto($pathToPhoto, $maxDimension, $force = false) {
	$orgImageFile = PHOTOS_DIR.$pathToPhoto;
	list($pathToPhotoNoExt,$ext) = explode(".",$pathToPhoto,2);
	$dstImageFile = CACHE_DIR.$maxDimension."/".$pathToPhotoNoExt.".jpg";

	if (!file_exists("$dstImageFile") || $force==true) {

		// create resized photo

		list($width, $height, $type, $attrImgTag, $mimeHeader, $channels, $bits ) = @getimagesize($orgImageFile);
		if (isset($type)) {
		
			echo $channels."\n".$bits;
			if ($width*$height*$channels*$bits/8>MAX_BYTES_ALLOC) {
				return ERROR_IMAGE;
			}
			
			if ($width >= $height) {
				$newwidth = $maxDimension;
				$newheight = (int)(($maxDimension*$height)/$width);
			} else {
				$newwidth = (int)(($maxDimension*$width)/$height);
				$newheight = $maxDimension;
			}
			
			$newImage = @imagecreate($newwidth, $newheight);
			if ($type == 1) {
				$image = imagecreatefromgif($orgImageFile);
			} else if ($type == 2) {
				$image = imagecreatefromjpeg($orgImageFile);
			} else if ($type == 3) {
				$image = imagecreatefrompng($orgImageFile);
			}
			@imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

			// export resized photo

			mkdir2(dirname($dstImageFile),0777);
			@imagejpeg($newImage, $dstImageFile, RESIZING_QUALITY);
		}
		else {
			return null;
		}
	}
	return $dstImageFile;
}

/**
 * return the exact width and height of an image in the cache directory
 */
function getPhotoSize($pathToPhoto, $maxSize) {
	$orgImageFile = PHOTOS_DIR.$pathToPhoto;
	list($pathToPhotoNoExt,$ext) = explode(".",$pathToPhoto,2);
	$resizedImageFile = CACHE_DIR.$maxSize."/".$pathToPhotoNoExt.".jpg";

	list($width, $height, $type, $attr) = @getimagesize($resizedImageFile);
	return array($width, $height);
}

/**
 * comments management. All comments is stocked in comments.dat (can be changed in config.php)
 * comments.dat is a text file, each line is information of a comment.
 */

class Comment {
	var $pathToPhoto;
	var $time;
	var $ip;
	var $name;
	var $email;
	var $text;

	function Comment() {}

	function assign($pathToPhoto, $time, $name, $email, $text) {
		$this->pathToPhoto = $pathToPhoto;
		$this->time = $time;
		if (isset($name) && $name!="")
		$this->name = $name;
		else
		$this->name = $_SERVER["REMOTE_ADDR"];
		if (isset($email) && $email!="")
		$this->email = $email;
		else
		$this->email = "anonymous";
		$this->text=textToHTML($text);
		$this->ip = $_SERVER["REMOTE_ADDR"];
	}

	function assignString($rep) {
        if (isset($rep) && $rep!=null && $rep!='')
		    list($this->pathToPhoto, $this->time, $this->ip, $this->name, $this->email, $this->text) = explode("|",$rep);
		else {
			$this->pathToPhoto=''; 
			$this->time='';
			$this->ip='';
			$this->name='';
			$this->email='';
			$this->text='';
		}	
	}

	function toString() {
		return $this->pathToPhoto
		. "|" . $this->time
		. "|" . $this->ip
		. "|" . $this->name
		. "|" . $this->email
		. "|" . $this->text;
	}

	function addMeToCache() {
		if (!file_exists(COMMENTS_FILE)) {
			touch(COMMENTS_FILE);
		}
		$f = fopen(COMMENTS_FILE,"a");
		fwrite($f, $this->toString()."\n");
		fclose($f);
	}

	function getID() {
		return $this->pathToPhoto."|".$this->time.$this->ip.$this->name;
	}
}

function getPathToPhotoFromIDComment($idcomment) {
	list($pathToPhoto,$remain)=explode("|",$idcomment);
	return $pathToPhoto;
}

function deleteComment($idcomment) {
	$arr = file(COMMENTS_FILE);
	$f = fopen(COMMENTS_FILE,"w");
	$c = new Comment();
	foreach ($arr as $line) {
		$c->assignString($line);
		if ($c->getID()!=$idcomment) {
			fwrite($f,$line);
		}
	}
	unset($c);
	fclose($f);
}

/**
 * Delete all comment of a photos
 *
 * @param String $pathToPhoto
 */
function deleteComments($pathToPhoto) {
	$cm = new Comment();

	$arr = file(COMMENTS_FILE);
	$f = fopen(COMMENTS_FILE,"w");

	foreach ($arr as $line) {
		$cm->assignString($line);
		if ($cm->pathToPhoto != $pathToPhoto) {
			fwrite($f,$line);
		}
	}
	fclose($f);
	unset($cm);
}

/**
 * Delete all comments which don't have an equivalent photo
 */
function cleanTrashyComments() {
	$cm = new Comment();
	$arr = file(COMMENTS_FILE);
	$f = fopen(COMMENTS_FILE,"w");

	foreach ($arr as $line) {
		$cm->assignString($line);
		if ($cm->pathToPhoto=="" || file_exists(PHOTOS_DIR.$cm->pathToPhoto)) {
			fwrite($f,$line);
		}
	}
	fclose($f);
	unset($cm);
}

/**
 * Get comments of a specific photo
 *
 * @param String $pathToPhoto
 * @return Comments[]
 */
function getComments($pathToPhoto) {
	if (!file_exists(COMMENTS_FILE)) {
		touch(COMMENTS_FILE);
	}
	$resu = array();
	$i = 0;
	$f = fopen(COMMENTS_FILE,"r");
	while (!feof($f)) {
		$line = fgets($f);
		$cm = new Comment();
		//$line comment is ended with a "\n", but the assignString don't accept
		//augument which contains "\n" we have to remove it before call assignString
		//that's why we have to call substr here
		$cm->assignString(substr($line, 0, -1));
		if ($cm->pathToPhoto == $pathToPhoto) {
			$resu[$i] = $cm;
			$i++;
		}
		else
		unset($cm);
	}
	fclose($f);
	return $resu;
}

//getComments(urldecode("2006-08-05+nha+co+Hoa%2FDSC01914.JPG"));
//echo urlencode("&");

/**
 * Get all comment of album
 *
 * @param String $pathToPhoto
 * @return Comments[]
 */
function getAllComments() {
	if (!file_exists(COMMENTS_FILE)) {
		touch(COMMENTS_FILE);
	}
	$resu = array();
	$i = 0;
	$f = fopen(COMMENTS_FILE,"r");
	while (!feof($f)) {
		if ($line = fgets($f)) {
			$resu[$i] = new Comment();
			//$line comment is ended with a "\n", but the assignString don't accept
			//augument which contains "\n" we have to remove it before call assignString
			//that's why we have to call substr here
			$resu[$i]->assignString(substr($line, 0, strlen($line)-1));
			$i++;
		}
	}
	fclose($f);
	return $resu;
}

function textToHTML($text) {
	$resu=htmlentities($text,ENT_QUOTES,"UTF-8");
	$resu=str_replace("\r","",$resu);
	$resu=str_replace("  ","&nbsp ",$resu);
	$resu=str_replace("\t","&nbsp &nbsp ",$resu);
	$resu=str_replace("\n","<br/>",$resu);
	return $resu;
}

/*****************************
* Main functions
*****************************/

/**
 * Delete an image and its equivalent VT file and comments
 * @param		$pathToPhoto	A string represent the photo. Eg: "Photo2006/myfamily.jpg"
 */
function deletePhoto($pathToPhoto) {
	//delete original photo
	@unlink(PHOTOS_DIR.$pathToPhoto);

	//delete equivalent comments
	@deleteComments($pathToPhoto);

	//clean cache (resized photos and thumbnails)
	$dh = opendir(CACHE_DIR);
	while ($sz = readdir($dh)) { // $sz = "120", "720", "vt"...
		if ($sz!="." && $sz!="..") {
			@unlink (CACHE_DIR.$sz."/".$pathToPhoto);
		}
	}
	closedir($dh);

	//delete vt file
	@unlink(getViewTimeFile($pathToPhoto));
}

function deleteGroup($groupName) {
	//TODO
}


/**
 * Remove all trashy files (in cache) and trasy comments
 */
function clean() {
	cleanTrashyComments();
	cleanInCache(CACHE_DIR); // clean trasy files in cache
	cleanInCache(VT_DIR); // clean trasy files in VT_DIR
	cleanAllEmptyDir();		// clean trasy folders
}

/**
 * get all photos in a group. Example: getPhotos("Photo2006") return {"Photo2006/myfamily.jpg", "Photo2006/mymother.jpg", "Photo2006/hiep.jpg",...}
 *
 * @param String $groupName
 * @return the array of photos in a group
 */
function getPhotos($groupName) {
	$resu = array();
	$i=0;
	if ($dh = opendir(PHOTOS_DIR.$groupName)) {
		while (($file = readdir($dh)) !== false) {
			if($file != "." && $file!=".." && hasImageExtension($file)){
				$resu[$i] = $groupName."/".$file;
				$i++;
			}
		}
		closedir($dh);
	}
	if (SORT_PHOTO_BY_NAME)
		array_multisort($resu,SORT_ASC,SORT_STRING);
	return $resu;
}


/**
 * Count numbers of photo of a groupe
 *
 * @param unknown_type $groupName
 */
function countPhotosInGroup($groupName) {
	$i=0;
	if ($dh = opendir(PHOTOS_DIR.$groupName)) {
		while (($file = readdir($dh)) !== false) {
			if($file != "." && $file!=".." && hasImageExtension($file)) {
				$i++;
			}
		}
		closedir($dh);
	}
	return $i;
}

/**
 * return number of group
 */
function countGroups() {
	$i=0;
	if ($dh = opendir(PHOTOS_DIR)) {
		while (($file = readdir($dh)) !== false) {
			if($file != "." && $file!=".." && is_dir(PHOTOS_DIR.$file)){
				$i++;
			}
		}
		closedir($dh);
	}
	return $i;
}

/**
 * return an array X where X[0] = numbers of photos, X[1] = numbers of groups
 * X[2] = album size
 */
function getStatistic() {
	$resu = array();
	$i=0;
	$g=0;
	$sz=0;
	// collect all photo name and equivalent view time to $photos and $vts
	if ($dh = @opendir(PHOTOS_DIR)) {
		while (($group = readdir($dh)) !== false) {
			if($group!="." && $group!=".."){
				$g++;
				$group = PHOTOS_DIR.$group;
				if ($dh2 = @opendir($group)) {
					while (($image = readdir($dh2)) !== false) {
						if($image!="." && $image!=".." && hasImageExtension($image)){
							$i++;
							$sz += filesize($group."/".$image);
						}
					}
					closedir($dh2);
				}
			}
		}
		closedir($dh);
	}
	$resu[0]=$i;
	$resu[1]=$g;
	$resu[2]=$sz;
	return $resu;
}

/**
 * rerturn number of comments
 */
function countComments() {
	if (!file_exists(COMMENTS_FILE)) return 0;
    $arr = file(COMMENTS_FILE);
	return count($arr);
}

/**
 * Return all group in an array, sort them by their name
 */
function getGroups() {
	$resu = array();
	$i=0;
	if ($dh = opendir(PHOTOS_DIR)) {
		while (($file = readdir($dh)) !== false) {
			if($file != "." && $file!=".." && is_dir(PHOTOS_DIR.$file)){
				$resu[$i] = $file;
				$i++;
			}
		}
		closedir($dh);
	}

	if (SORT_GROUP_BY_NAME)
		array_multisort($resu,SORT_DESC,SORT_STRING);

	return $resu;
}


/**
 * return array of all image, sorted by view's time (the first element of array is path to
 * the most view photo, the last element of array is path to the least view photo)
 */
function getAllPhotos() {
	$i=0;
	$photos = array();
	$vts = array();
	// collect all photo name and equivalent view time to $photos and $vts
	if ($dh = @opendir(PHOTOS_DIR)) {
		while (($group = readdir($dh)) !== false) {
			if($group!="." && $group!=".."){
				if ($dh2 = @opendir(PHOTOS_DIR.$group)) {
					while (($image = readdir($dh2)) !== false) {
						if($image!="." && $image!=".." && hasImageExtension($image)){
							$pathToPhoto = $group."/".$image;
							$photos[$i] = $pathToPhoto;
							$vts[$i] = getViewTime($pathToPhoto);
							$i++;
						}
					}
					closedir($dh2);
				}
			}
		}
		closedir($dh);
	}
	array_multisort($vts,SORT_DESC,SORT_NUMERIC,$photos);
	return $photos;
}


function make_seed() {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
}
/**
* return a table of some random photo
*/
function getRandomPhotos($howmany) {
	$resu = array();
	$photos = getAllPhotos();
	
	$bord = count($photos)-1;
	
	srand(make_seed());
	
    if (count($photos)<$howmany)
        $howmany =count($photos);
	for ($i = 0; $i < $howmany; $i++) {
		// choose an image r
		$r = rand(0,$bord); 
		// put in the resu
		$resu[$i] = $photos[$r];
		// move r to the end of the table
		$tmp = $photos[$r];
		$photos[$r] = $photos[$bord];
		$photos[$bord] = $tmp;
		$bord--; // we ignore the $photos[$bord] was already choosen
	}
	return $resu;
}


/*
function strEncode($pass_str) {
$pass_coder =  mcrypt_ecb(MCRYPT_TripleDES, PASSWORD, $pass_str, MCRYPT_ENCRYPT);
return $pass_coder;
}

function strDecode($pass_coder) {
$pass_str =  mcrypt_ecb(MCRYPT_TripleDES, PASSWORD, $pass_coder, MCRYPT_DECRYPT);
return $pass_str;
}
*/

//ecncrypt $data with the key in $keyfile with an rc4 algorithm
/**
 * using the function on plaintext returns the Encrypted string and using it
 * on encrypted text returns the plaintext... its that simple. The security
 * of the algorythmn is dependant on the size of the key used and any size key
 * can be used with this function.
 */
function rc4($data) {
	$pwd_length = strlen(PASSWORD);
	for ($i = 0; $i < 255; $i++) {
		$key[$i] = ord(substr(PASSWORD, ($i % $pwd_length)+1, 1));
		$counter[$i] = $i;
	}
	for ($i = 0; $i < 255; $i++) {
		$x = ($x + $counter[$i] + $key[$i]) % 256;
		$temp_swap = $counter[$i];
		$counter[$i] = $counter[$x];
		$counter[$x] = $temp_swap;

	}
	for ($i = 0; $i < strlen($data); $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $counter[$a]) % 256;
		$temp = $counter[$a];
		$counter[$a] = $counter[$j];
		$counter[$j] = $temp;
		$k = $counter[(($counter[$a] + $counter[$j]) % 256)];
		$Zcipher = ord(substr($data, $i, 1)) ^ $k;
		$Zcrypt .= chr($Zcipher);
	}
	return $Zcrypt;
}
/*
//test rc4
$x=urlencode(rc4("http://duongphuhiep.free.fr/alibumbum/index.php?page=2006-07-13+Do+cu+ngoai%2FDSC01827.JPG"));
echo $x."<br>\n";
echo rc4(urldecode($x));
*/

list($width, $height, $type, $attrImgTag, $mimeHeader, $channels, $bits ) = @getimagesize("photos/2009-07-26 Buoi toi o Nice/DSC02555.JPG");
echo "width: ".$width."<br>";
echo "height: ".$height."<br>";
echo "type: ".$type."<br>";
echo "attrImgTag: ".$attrImgTag."<br>";
echo "mimeHeader: ".$mimeHeader."<br>";
echo "channels: ".$channels."<br>";
echo "bits: ".$bits."<br>";
?>



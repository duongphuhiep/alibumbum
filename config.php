<?php

// change to whatever u want

define('PASSWORD', 'hiep@84');

// you can change (if u want)

define('CACHE_DIR', 'cache/');
define('DATA_DIR', 'data/');
define('TEMPLATES_DIR', 'templates/');
define('PHOTOS_DIR', 'photos/');
define('DEFAULT_TEMPLATE', 'phpalbum');
define('SORT_GROUP_BY_NAME', true);
define('SORT_PHOTO_BY_NAME', true);

// not recommended to change, and need to update cache

define('COMMENTS_FILE', DATA_DIR.'comments.dat');
define('VT_DIR', DATA_DIR.'vt/');
define('RESIZING_QUALITY', 75);	// 0..100 (100 for the best quality)

//ini_set('memory_limit', '64M');

?>
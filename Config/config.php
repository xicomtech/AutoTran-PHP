<?php
//Admin Email ID
define('ADMIN_EMAIL', '' );
define('APP_NAME', 'Autotran' );

define('WEBURL', 'http://'.$_SERVER['HTTP_HOST'].'/autotran/website/');

define('PHOTOS_DIR', WWW_ROOT. 'upload' .DS. 'photos' .DS );
define('PHOTOS_URL', WEBURL .'upload/photos/' );

define('STATUS_ACTIVE', 1);
define('STATUS_INACTIVE', 0);

define('STATUS_SHIPPED', 1);
define('STATUS_UNSHIPPED', 0);

define('ADMIN_PAGE_LIMIT',30);

define('INTERVAL_DAYS',30);
define('UPLOAD_DIR','files/');

define('SMALL','S_');
define('MEDIUM','M_');
define('LARGE','L_');

$config = array ();

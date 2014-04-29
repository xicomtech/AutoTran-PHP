<?php
$config = array();
// users constants
define('API_PRIVATE_KEY', 'AutoTran');

Configure::write('api_private_key', API_PRIVATE_KEY);
Configure::write('expiry_seconds', 120);
define('IPHONE_CERTIFICATE_URL','ssl://gateway.sandbox.push.apple.com:2195');
define('IPHONE_CERTIFICATE','iphone_certificates_sandbox.pem');
define('GOOGLE_API_KEY','AIzaSyDuR5N8g4e9j63EcT065B3o9xHzivQY24c');


define('SIGNATURE_UPLOADED_FAILED', 'Oops, your signature not uploaded due to some internal reasons. Please try after some time.');
define('MAX_UPLOAD_PICTURE_SIZE', '5242880');  // 5 MB
define('SELECT_FILE', 'Please select the image file.');
define('VALID_FORMATS', 'jpg,jpeg,png,gif');
define('INVALID_PICTURE_FORMAT', 'Only jpg, jpeg, png, gif extensions are allowed.');
define('NOTES_IMG_DIR', 'files/notes');
define('PICTURE_UPLOADED_FAILED', 'Oops, your picture not uploaded due to some internal reasons. Please try after some time.');

define('PICTURE_UPLOADED_SUCCESS', 'Your picture has been uploaded .');
define('VIN_IMAGES', 'media');

class UserType
{
	const UserDriver = 'driver';
	const UserDealer = 'dealer';
}


?>

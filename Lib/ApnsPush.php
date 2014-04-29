<?php
/**
 * This file contains class for push notification
 *
 * Project: PimWimy
 * @version  $Id$
 * @since 10th Jan 2013
 * 
 */

class ApnsPush
{

	const ENVIROMENT_SANDBOX = 1;
	const ENVIROMENT_PRODUCTION = 0;
	const SANDBOX_URL = 'ssl://gateway.sandbox.push.apple.com:2195';
	const PRODUCTION_URL = 'ssl://gateway.push.apple.com:2195';

	protected $remote_socket = 'ssl://gateway.sandbox.push.apple.com:2195';
	public $apns_cer_file = null;
	
/**
 * Constructor
 * 
 * @param string $cert_file path to certificate file(.pem file), Certificate file must comply with the working enviroment
 * @param int $enviroment either in developement mode or production, 0 for production 1 for developement
 * @throws InvalidArgumentException if certificate file not found
 * @return void
 * @access Public
 * 
 */
	public function __construct($cert_file, $enviroment = self:: ENVIROMENT_SANDBOX)
	{
		if (!is_file($cert_file))
		{				
			throw new InvalidArgumentException('Certificate file is not readable');
		}
		$this->apns_cer_file = $cert_file;
		if ($enviroment == self::ENVIROMENT_PRODUCTION)
		{
			$this->remote_socket = self::PRODUCTION_URL;
		}
		else
		{
			$this->remote_socket = self::SANDBOX_URL;
		}
	}

/**
 *  Sends push notification
 * 
 * @param string $message
 * @param string $device_token
 * @since 10th Jan 2013
 *	 
 */
	Public function send_push_notification($message, $device_token, $badge = 1, $sound = 'default', $data = null)
	{
		//$remote_socket = 'ssl://gateway.push.apple.com:2195';
		// Create a stream to the server
		$streamContext = stream_context_create();
		stream_context_set_option($streamContext, 'ssl', 'local_cert', $this->apns_cer_file);
		$errorCode = '';
		$errorString = '';
		$apns = stream_socket_client($this->remote_socket, $errorCode, $errorString, 60, STREAM_CLIENT_CONNECT, $streamContext);
		// You can access the errors using the variables $errorCode and $errorString
		// Now we need to create JSON which can be sent to APNS
		if (empty ($badge))
		{
			$badge = 1;
		}
		if($data == null)
		{
			$load = array(
				'aps' => array(
					'alert' => $message,
					'badge' => $badge,
					'sound' => $sound
				)
			);
		}
		else
		{
				$load = array(
				'aps' => array(
					'alert' => $message,
					'badge' => $badge,
					'sound' => $sound
				),
				'd' => $data
			);
		
		}
		$payload = json_encode($load);
		// The payload needs to be packed before it can be sent
		$apnsMessage = chr(0) . chr(0) . chr(32);
		$apnsMessage .= pack('H*', str_replace(' ', '', $device_token));
		$apnsMessage .= chr(0) . chr(strlen($payload)) . $payload;
		// Write the payload to the APNS
		fwrite($apns, $apnsMessage);
		// Close the connection
		fclose($apns);
	}

}


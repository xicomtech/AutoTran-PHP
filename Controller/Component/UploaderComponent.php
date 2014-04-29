<?php
 /**
	 *Uploader component
	 *
	 * Purpose : upload Image, creating thumb
	 * @project Auto Tran
	 * @since 17-October-2013
	 * @author : Santosh Gupta
	 */
class UploaderComponent extends Component 
{
	public $name = 'Uploader';
	
/**
 * property that will be used to store uploaded file name(path).
  * @var string
 */
	public $newfile_path;
	
/**
 * property to manage error in uploading.
 * @var boolean
 */
	public $error = false;
	
/**
 * property that will be store error message.
 * @var string
 */
	public $errorMessage;
/**
 * property to allow the file uplaoding extension.
 * @var array
 */
	private $allow_extensions = array('jpg', 'jpeg', 'png', 'gif', 'bit');
/**
 * property image source dir path.
 * @var string
 */
	private $source_dir;
	
/**
 * property image destination dir path.
 * @var string
 */
	private $destination_dir;
/**
 * property thumbnails directory path.
 * @var string
 */
	private $thumb_dir;
	
/**
 * property max_file_size.
 * @var string
 * define maximum uploading file size (default 2M = 2*1024*1024)
 */
	public $max_file_size = 20;
	
/**
 * property that will be used to allow to create thumbnails.
 * @var array
 */
	public $thumb =  array(
				array(
					'width'=>50,
					'height'=>50,
					'suffix' => SMALL
				),
				array(
					'width'=>98,
					'height'=>98,
					'suffix' => MEDIUM
				),
				array(
					'width'=>350,
					'height'=>350,
					'suffix' => LARGE
				)
			);
	
/**
 * upload the image 
 * @param array $files, post uplaoded file
 * @param string $destination_dir, directory path where images will be upload
 * @param $thumb boolean, create thumb default true
 * @param array $params, that contains create thumb attributes
 * @param $save_filename (string), file 
 * return uploaded file name
 */
 public function upload($file, $destination_dir, $thumb = false, $save_filename = '', $params = array())
 {
	if ( !empty($file) )
	{		
		$ext = array_pop( explode('.', $file['name']) );
		$ext = strtolower($ext);
		// Maximum allowed size in bytes
		$max_size = $this->max_file_size * 1024 * 1024; // converted MB to bytes
		
		if ( $max_size < $file['size'])
		{
			$this->error = true;
			$this->errorMessage =  __('File size should be less than %dMB', $this->max_file_size);
			return $this->errorMessage;
		}
		
		if ( in_array($ext, $this->allow_extensions ) && $file['error'] == 0 )
		{
			//Image width validation
			$file_info = getimagesize( $file['tmp_name'] );
			
			if ( empty($this->filename) )
			{
				if (! empty($save_filename) )
				{
					$file_name = $save_filename ;
				}
				else
				{
					$file_name = uniqid() . '.' . $ext;
				}
			}
			else
			{
				$file_name = $this->filename;
			}
			
			if ( !is_dir($destination_dir))
			{
				mkdir($destination_dir, 0777);
			}
			
			$upload_file = $destination_dir . $file_name;
			if ( file_exists($upload_file ) )
			{
				unlink( $upload_file );
			}
			
			if ( is_array($file) )
			{
				$source_file_path = $file['tmp_name'];
			}
			else
			{
				$source_file_path = $file;
			}
			
			if ( move_uploaded_file( $source_file_path, $upload_file) )
			{
				//Create thumbnails from uploaded image
				if ( $thumb )
				{
					foreach ( $this->thumb as $thumb_img)
					{
						$src_file = $upload_file;
						$newfile_path = $destination_dir. $thumb_img['suffix'] . $file_name;
						$new_w =  $thumb_img['width'];
						$new_h =  $thumb_img['height'];
						$this->createthumb($src_file, $newfile_path, $new_w,$new_h);
					}
				}
				return $this->filename = $file_name;
			}
		}
		else
		{
			$this->error = true;
			$this->errorMessage =  __('Please check the format of your photo and try again. We support these photo formats: JPG, GIF and PNG.');
		}
	}
	else
	{
		$this->error = true;
		$this->errorMessage = __('File not uploaded');
	}
 }
/**
 * Crop the image
 * @params array $filedata source and destination files
 * @params array $file_dimension crop image dimensions
 * @params $is_thumb boolean, create thumb default true
 * @params array $params thumbnail info
 * return (string) filename;
 */
	public function crop( $filedata, $file_dimension, $is_thumb = true, $params = array() )
	{
		$targ_w =  $file_dimension['width'];
		$targ_h =  $file_dimension['height'];
		$quality = 95;

		$src = $filedata['source_path'];
		
		
		
		$system = explode(".",$src);
		$extension = end($system);
		$file_name = uniqid() . '.' . $extension;
		$this->filename = $file_name;
		$newfile_path = $filedata['dest_dir'] . $file_name;
		
		if (preg_match("/jpg|jpeg/i",$extension))
		{
			$src_img = @imagecreatefromjpeg($src);
		}
		if (preg_match("/png/i",$extension))
		{
			$src_img = @imagecreatefrompng($src);
		}
		if (preg_match("/gif/i",$extension))
		{
			$src_img = @imagecreatefromgif($src);
		}
		
		$dst_img = @ImageCreateTrueColor( $targ_w, $targ_h );

		@imagecopyresampled($dst_img, $src_img, 0,0, $file_dimension['x'], $file_dimension['y'], $targ_w,$targ_h, $file_dimension['width'], $file_dimension['height']);

		//header('Content-type: image/jpeg');
		//imagejpeg($dst_img,null,$quality);
		
		$dst_img = @imagecreatetruecolor($targ_w,$targ_h);

		if(preg_match("/png/i",$extension))
		{
			// Turn off transparency blending (temporarily)
			@imagealphablending($dst_img, false);   
			// Create a new transparent color for image
			$color = imagecolorallocatealpha($dst_img, 0, 0, 0, 127);   
			// Completely fill the background of the new image with allocated color.
			@imagefill($dst_img, 0, 0, $color);   
			// Restore transparency blending
			@imagesavealpha($dst_img, true);
		}
		else
		{
		
			$trnprt_indx = @imagecolortransparent($src_img);

		// If we have a specific transparent color
			if ($trnprt_indx >= 0) 
			{
			// Get the original image's transparent color's RGB values
				$trnprt_color    = @imagecolorsforindex($src_img, $trnprt_indx);
				// Allocate the same color in the new image resource
				$trnprt_indx    = @imagecolorallocate($dst_img, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
				// Completely fill the background of the new image with allocated color.
				@imagefill($dst_img, 0, 0, $trnprt_indx);
				// Set the background color for new image to transparent
				@imagecolortransparent($dst_img, $trnprt_indx);
			}
		}
		@imagecopyresampled($dst_img, $src_img, 0,0, $file_dimension['x'], $file_dimension['y'], $targ_w,$targ_h, $file_dimension['width'], $file_dimension['height']);
		
		if (preg_match("/png/i", $extension))
		{
			@imagepng($dst_img, $newfile_path); 
		}
		else if(preg_match("/gif/i",$extension))
		{
			@imagegif($dst_img, $newfile_path); 
		} 
		else 
		{
			@imagejpeg($dst_img, $newfile_path, $quality); // Quality setting 95 
		}
		@imagedestroy($dst_img); 
		@imagedestroy($src_img); 
		
		// Remove source file
		if ( file_exists( $filedata['source_path'] ) )
		{
			unlink($filedata['source_path']);
		}
		
		//Create thumbnails
		if ( $is_thumb )
		{
			foreach ( $this->thumb as $thumb_img)
			{
				$src_file = $filedata['dest_dir'] .  $file_name;
				$newfile_path = $filedata['dest_dir'] . $thumb_img['suffix'] . $file_name;
				$new_w =  $thumb_img['width'];
				$new_h =  $thumb_img['height'];
				$this->createthumb($src_file, $newfile_path, $new_w, $new_h);
			}
		}
		 $this->filename = $file_name;
		return $this->filename;
	}
/**
 * createthumb : use to create the thumbnails
 * @params string $name source file path
 * @params strind $newfile_path creating file path
 * @params int $new_w width in pixcel
 * @params int $new_h height of the image in pixcel
 * return
 */	
	
	function createthumb($name, $newfile_path, $new_w, $new_h)
	{

		$system = explode(".",$name);
		$extension = end($system);
		
		if (preg_match("/jpg|jpeg/i",$extension))
		{
			$src_img = @imagecreatefromjpeg($name);
		}
		if (preg_match("/png/i",$extension))
		{
			$src_img = @imagecreatefrompng($name);
		}
		if (preg_match("/gif/i",$extension))
		{
			$src_img = @imagecreatefromgif($name);
		}
		$old_x = @imageSX($src_img);
		$old_y = @imageSY($src_img);
		
		$vertical_shrink_ratio = $old_x > $new_w ? $new_w/ $old_x : 1;
		$horizontal_shrink_ratio = $old_y > $new_h ? $new_h / $old_y : 1;
		$shrink_ratio = min($vertical_shrink_ratio, $horizontal_shrink_ratio);
		
		$thumb_w = $old_x * $shrink_ratio;
		$thumb_h = $old_y * $shrink_ratio;

		$dst_img = @imagecreatetruecolor($thumb_w,$thumb_h);

		if(preg_match("/png/i",$extension))
		{
			// Turn off transparency blending (temporarily)
			@imagealphablending($dst_img, false);   
			// Create a new transparent color for image
			$color = @imagecolorallocatealpha($dst_img, 0, 0, 0, 127);   
			// Completely fill the background of the new image with allocated color.
			@imagefill($dst_img, 0, 0, $color);   
			// Restore transparency blending
			@imagesavealpha($dst_img, true);
		}
		else
		{
		
			$trnprt_indx = imagecolortransparent($src_img);

		// If we have a specific transparent color
			if ($trnprt_indx >= 0) 
			{
			// Get the original image's transparent color's RGB values
			$trnprt_color    = imagecolorsforindex($src_img, $trnprt_indx);
			// Allocate the same color in the new image resource
			$trnprt_indx    = imagecolorallocate($dst_img, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
			// Completely fill the background of the new image with allocated color.
			imagefill($dst_img, 0, 0, $trnprt_indx);
			// Set the background color for new image to transparent
			imagecolortransparent($dst_img, $trnprt_indx);
			}
		}
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		if (preg_match("/png/i",$extension))
		{
			imagepng($dst_img,$newfile_path); 
		}
		else if(preg_match("/gif/i",$extension))
		{
			imagegif($dst_img,$newfile_path); 
		} 
		else 
		{
			imagejpeg($dst_img,$newfile_path,95); // Quality setting 95 
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img); 
	}
/**
 * remove : remove the files
 * @params string $filename 
 * @params string $dir_path directory path form file has to be remove
 * return : null
 */
 public function remove( $filename, $dir_path)
 {
	$file_path = $dir_path .  $filename;
	if ( file_exists($file_path) )
	{
		unlink($file_path);
	}
	foreach ( $this->thumb as $thumb_img)
	{
		$file_path = $dir_path. $thumb_img['suffix'] . $filename;
		if ( file_exists($file_path) )
		{
			unlink($file_path);
		}
	}
 }
/**
 * facebook_image : remove the files
 * @params int $facebook_id 
 * @params string $destination_dir directory path where file hase been saved
 * return : string (file name'
 */
	public function facebook_image($facebook_id, $destination_dir)
	{
		// Pulling facebook user profile picture
		$fb_img = @file_get_contents('http://graph.facebook.com/'.$facebook_id.'/picture?type=large');
		$this->filename = $file_name = uniqid().'.jpg';
		
		$source_path = TMP . $file_name;
		
		@file_put_contents( $source_path , $fb_img);
		
		$file_info = getimagesize( $source_path );
		
		if ( !is_dir($destination_dir))
		{
			mkdir($destination_dir, 0777);
		}
		$dest_path = $destination_dir;
		$filedata = array(
			'source_path' => $source_path,
			'dest_dir' => $dest_path,
			'file_name' => $file_name
		);
		$file_dimension = array(
			'width' => $file_info['0'],
			'height' => $file_info['1'],
			'x' => 0,
			'y' => 0
		);
		//Croping the image
		$this->crop( $filedata, $file_dimension, true);
		return $this->filename;
	}
}

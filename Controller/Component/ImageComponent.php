<?php

/* Resize Dimension Settings */
define("RESIZE_HEIGHT", "height");
define("RESIZE_WIDTH", "width");
define("RESIZE_BOTH", "both");
define("RESIZE_AUTO", "auto");

/**
 * ImageResizeComponent handles our image uploads and user defined image resize. The class attempts to
 * use ImageMagick as the default and the GD Library as the backup.
 * 
 * @author hunzinker@gmail.com
 *
 */

class ImageComponent extends Component {
	
	/**
	 * Version of ImageMagick
	 * @var int
	 */
	var $im_version = null;
	
	/**
	 * Tmp Resize Directory
	 * @var string
	 */
	var $resizeTmpFile = '/files/uploaded/resize/resize.tmp';
	
	/**
	 * Path where the uploaded images will be stored.
	 * @var unknown_type
	 */
	var $file_path = '/files/uploaded/img/';
	
	/**
	 * Class Constructor
	 * Sets the ImageMagick version if applicable and the DOC ROOT.
	 */
	function startup(Controller $controller) {
		// set the doc root file path
		$this->file_path = env('DOCUMENT_ROOT') . $this->file_path;
		$this->resizeTmpFile = env('DOCUMENT_ROOT') . $this->resizeTmpFile;
		
		$version = null;
		exec("convert -version", $results, $ret_val);
		if ($ret_val == '127') {
			/* We don't have permission to use exec() or ImageMagick is not installed. */
			$this->im_version = $version;
		} else {
			if(count($results))
			{
				$pieces = explode(' ', $results[0]);
				$version = $pieces[2];
			}
			$this->im_version = $version;
		}
	}
	
	/**
	 * Uploads the file and calls resize() on success.
	 * 
	 * @param $file_name
	 * @param $resize_data
	 * @return $errors
	 */
	function uploadFile ($file, $resize_data = array()) {
		$errors = array(); 
		if (!is_array($file)) {
			$errors['file_name'] = "The filename was not passed as an array.";
			return $errors;
		}
		
		$file_tmp_name = $file['tmp_name'];
		$file_name = $file['name'];
		
		$dim_setting = $dim1 = $dim2 = null;
		if (!move_uploaded_file($file_tmp_name, $this->resizeTmpFile)) { 
			$errors['moveUploaded'] = "move_uploaded_file() failed.";	
			return $errors; 
		}
		if (!empty($resize_data)) {
			foreach ($resize_data as $key => $value) {
				$dim_setting = $value[0];
				$dim1 = $value[1];
				$dim2 = $value[2];
			}
		}
		
		// resize the image
		$errors = $this->resize($this->resizeTmpFile, $this->file_path . $file_name, $dim_setting, $dim1, $dim2);
		
		return $errors;
			
	}
	
	/**
	 * Purpose : TO ADD POSTFIX TO THE FILENAME
	 * Created on : 8-Dec-2011
	 * Author : Nitin
	*/
	function addPostfixTofilename($file_name, $postfix)
	{
		$dotpos = strrpos($file_name, '.');
		$firstpart = substr($file_name, 0, $dotpos);
		$ext = substr($file_name, ($dotpos+1));
		return $postfix.'.'.$ext;
	}
	
	/**
	 * Resizes an image using Either ImageMagick or the GD Library. See var $im_version for more information.
	 * 
	 * @param $src
	 * @param $target
	 * @param $dim_setting	
	 * @param $dim1
	 * @param $dim2
	 * @return $errors
	 */
	function resize($src, $dim1, $dim2 = false, $thumb_subloc, $dim_setting = RESIZE_AUTO, $rename_flag = false) 
	{
		$errors = array();
		
		// Can we use the GD Library?
		if (!$src) {
			/* $errors['src'] = "Could not call imagecreatefrom" . $ext . "() in the GD library. Please check your server
							  settings and try again.";
			return $errors; */
		}
		
		list($width, $height, $type, $attr) = getimagesize($src);
		
		if (!empty($dim1)) {
			// if the image is too small in width
			if ($dim_setting == 'width' && $width < $dim1) {
				/* $errors['width_setting'] = "The image " . $dim_setting . " is less than " . $dim1 . " px. 
					 				Please upload an image at least " . $dim1 . " px in " . $dim_setting;
				return $errors; */
			}
			// if the image is too small in height
			if ($dim_setting == 'height' && $height < $dim2) {
				/* $errors['height_setting'] = "The image " . $dim_setting . " is less than " . $dim1 . " px. 
					 				 Please upload an image at least " . $dim1 . " px in " . $dim_setting;
				return $errors; */
			}
		} else {
			/* $errors['dim_setting'] = "The resize dimension is not set. 
				              Please see " . Inflector::camelize($this->params['controller']) . " for more details.";
			return $errors; */
		}

		/*
		 * Execute the following if you don't have permission to use exec() or ImageMagick is not installed.
		 * Note: The GD Library must be compiled with PHP!
		 */
		//if (empty($this->im_version)) {
		if(1)
		{
			
			// get the size of the image
			list($width, $height) = getimagesize($src);
			
			if(($slpos = strrpos($src, '/')) != false)
			{
				$src_img_name = substr($src, ($slpos+1));
			}
			else
			{
				$src_img_name = $src;
			}
			
			if(!file_exists($src)){
				return '';
			}
			
			// this handles our resize info
			if ($dim_setting == "width") 
			{
				$newWidth = $dim1;
				$newHeight = (int)(($height / $width) * $newWidth);
				
				$thumb_imgname = $this->addPostfixTofilename($src_img_name, $newWidth.'x');
			}
			else if ($dim_setting == "height") 
			{
				$newHeight = $dim2;
				$newWidth = (int)(($width / $height) * $newHeight);
				
				$thumb_imgname = $this->addPostfixTofilename($src_img_name, 'x'.$newHeight);
			} 
			else if ($dim_setting == "both")
			{
				$thumb_imgname = $this->addPostfixTofilename($src_img_name, 'both_'.$dim1.'x'.$dim2);
				$newWidth = $dim1;
				$newHeight = $dim2;
			}
			else 
			{
				// default
				/*
				 * if ($height > $width) {
					$newHeight = $dim2;
					$newWidth = (int)(($width / $height) * $newHeight);
				}
				else
				* */
				if ($height == $width) 
				{
					if($dim1 < $dim2)
					{
						$newWidth = $dim1;
						$newHeight = $dim1;
					}
					elseif($dim2 < $dim1)
					{
						$newWidth = $dim2;
						$newHeight = $dim2;
					}
					else
					{
						$newWidth = $dim1;
						$newHeight = $dim2;
					}
				}
				else 
				{
					//OLD CODE OF COMPONENT
					$newWidth = $dim1;
					$newHeight = $dim2;
					//TILL HERE
					
					//BELOW CODE REFERENCE IS TAKEN FROM IMAGE_LIB OF CODEIGNITER
					$temp_new_width	= ceil($width*$dim2/$height);
					$temp_new_height	= ceil($dim1*$height/$width);

					$ratio = (($height/$width) - ($dim2/$dim1));

					$master_dim = ($ratio < 0) ? 'width' : 'height';

					if (($dim1 != $temp_new_width) AND ($dim2 != $temp_new_height))
					{
						if ($master_dim == 'height')
						{
							$newWidth = $temp_new_width;
							$newHeight = $dim2;
						}
						else
						{
							$newHeight = $temp_new_height;
							$newWidth = $dim1;
						}
					}
					//TILL HERE

					//echo $master_dim.'----'.$dim1.'---'.$dim2.'---'.$newWidth.'---'.$newHeight.'<br/>';
				}
				

				$thumb_imgname = $this->addPostfixTofilename($src_img_name, $dim1.'x'.$dim2);
			}
			
			if($rename_flag)
			{
				$target = $src;
			}
			else
			{
				$this->append_slash($thumb_subloc);
				$target = $thumb_subloc.$thumb_imgname;
				//die($target);
			}
			
			/*if(file_exists($target))
			{
				return $target;
			}*/
			
			$ext = $this->fileExt($src_img_name);
			
			$image_type = getimagesize($src);
			
			// call the proper function based on file extension
			switch ($image_type[2]) {
				case 1:
					$src = imagecreatefromgif($src);
					break;
				case 2:
					$src = imagecreatefromjpeg($src);
					break;
				case 3:
					$src = imagecreatefrompng($src);
					break;
				default:
					$errors['ext'] = "Could not recoginze the file extension. Please upload a jpg, jpeg, png or gif.";
			}


			// create the tmp image and resize it
			$tmp = imagecreatetruecolor($newWidth, $newHeight);
			imagealphablending($tmp, false);
			imagesavealpha($tmp, true);
			if (!empty($tmp)) {
				imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			} else {
				$errors['imagecreatetruecolor'] = "imagecreatetruecolor() failed. Please check your server settings and try again.";	
			}
			
			/** Create the resized image. **/
			// call the proper function based on file extension
			switch ($ext) {
				case 'jpg':
					imagejpeg($tmp, $target, 100);
					break;
				case 'jpeg':
					imagejpeg($tmp, $target, 100);
					break;
				case 'png':
					imagepng($tmp, $target, 0);
					break;
				case 'gif':
					imagegif($tmp, $target);
					break;
				default:
					$errors['ext'] = "Could not recoginze the file extension. Please upload a jpg, jpeg, png or gif.";
			}
			
			// destroy the tmp image
			imagedestroy($tmp);
			
			return $target;
		}
		else 
		{
			/* Use ImageMagick to handle the resize. */
			$resizeDims = "";
			switch($dim_setting) {
				case RESIZE_HEIGHT:
					$resizeDims = "x" . $dim1;
					break;
				case RESIZE_WIDTH:
					$resizeDims = $dim1;
					break;
				case RESIZE_BOTH:
					if (!$dim2) { 
						$errors['resize_both'] = "You are attemping to resize on both width and height, but the second dimension
												  was not set.";
						return $errors; 
					}
					$resizeDims = $dim1 . "x" . $dim2;
					break;
				case RESIZE_AUTO:
					// we just fall through to the default
				default:
					if (!$dim2) {
						// we need to figure out which side to resize on
						// since only one of the dims are set
						if ($height > $width) {
							$resizeDims = "x" . $dim1;
						} else {
							$resizeDims = $dim1;
						}
					} else {
						// since both are set we do a full resize
						// on both of the dims
						$resizeDims = $dim1 . "x" . $dim2;
					}
			}
		
			// set the command for the proper Image Magic Version
			if ($this->im_version < 6) { 
				$command = "convert -resize $resizeDims +profile '*' $src $target";
			} else { 
				$command = "convert $src -resize $resizeDims +profile '*' $target"; 
			}
			
			exec($command, $results);
		
			if (count($results) > 0) { 
				$errors['image_magick'] = "The ImageMagick resize did not execute successfully."; 
				return $errors; 
			}
				return $errors;
		}
	}
	
	/**
	 * Removes a file from the server.
	 *
	 * @param string $path
	 * @param string $fileName
	 * @return 
	 */
	function removeFile($path, $fileName) {
		$file = $path . $fileName;
		if (file_exists($file)) { 
			return unlink($file); 
		}
		return false;
	}
	
	/**
	 * Checks to make the File was uploaded via HTTP POST.
	 * @param $params
	 * @return unknown_type
	 */
	function isUploadedFile($params) {
		if ((isset($params['error']) && $params['error'] == 0) || 
			(!empty($params['tmp_name']) && $params['tmp_name'] != 'none')) {
			return is_uploaded_file($params['tmp_name']);
		} else {
			return false;
		}
	}
	
	/**
	 * Grabs the file extension.
	 *
	 * @param $file
	 * @return string $ext
	 */
	function fileExt ($file) {
		$ext = substr(strrchr($file, '.'), 1);
		return strtolower($ext);
	}
	
	function append_slash(&$str)
	{
		if((strrpos($str, DS)+1) != strlen($str))
		{
			$str .= DS;
		}
	}
} 
?>

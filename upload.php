<?php

require_once('./vendor/autoload.php');
use Verot\Upload\Upload;

if (sizeof($_POST)) {
	$arrImagesProperties = [
		1 => [
			'path' => './images/thumbnail/',
			'width' => 150,
			'height' => 150
		],
		2 => [
			'path' => './images/medium/',
			'width' => 300,
			'height' => 300
		],
		3 => [
			'path' => './images/large/',
			'width' => 500,
			'height' => 500
		],
		4 => [
			'path' => './images/full/',
			'width' => 1000,
			'height' => 1000
		]
	];

	$handle = new Upload($_FILES['image_field']);

	if ($handle->uploaded) {
		$newFilename = sha1(time());
		
		for ($i = 1; $i <= 4; $i++) { 
			$path   = $arrImagesProperties[$i]['path'];
			$width  = $arrImagesProperties[$i]['width'];
			$height = $arrImagesProperties[$i]['height'];

			$handle->file_new_name_body = $newFilename;
			$handle->image_resize = true;			
			$handle->image_x      = $width;
			$handle->image_y      = $height;

			$handle->process($path);
			
			if ($handle->processed) {
				$srcImage = $path . '/' . $newFilename . '.jpg';

				echo '<p>Created image ' . $width . 'x' . $height . ' em "' . $path . '"</p>';
				echo '<img src="' . $srcImage . '" alt="" /><br><br><br>';
			} else {
				echo '<p>Erro to created image ' . $width . 'x' . $height . ' em "' . $path . '"</p>';
			}
		}

		$handle->clean();
	}
}


?>

<form enctype="multipart/form-data" method="post" action="upload.php">
  <input type="file" size="32" name="image_field" value="">
  <input type="submit" name="Submit" value="upload">
</form>
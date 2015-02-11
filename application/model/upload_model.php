<?php

class fileUploadModel extends controller
{
	public function upload(){
			$echo = '';
			$allowedExts = array("jpeg", "jpg", "pjpeg");
			$temp = explode(".", $_FILES["file"]["name"]); 
			$extension = end($temp);

			if ((($_FILES["file"]["type"] == "image/jpeg")
			|| ($_FILES["file"]["type"] == "image/jpg")
			|| ($_FILES["file"]["type"] == "image/pjpeg"))
			&& ($_FILES["file"]["size"] < 20000000)
			&& in_array($extension, $allowedExts)) {
			if ($_FILES["file"]["error"] > 0) {
				$echo .= "Return Code: " . $_FILES["file"]["error"] . "<br>";
			} else {
				if (file_exists(ROOT . "public/img/" . $_FILES["file"]["name"])) {
					$echo .=$_FILES["file"]["name"] . " already exists. <br>";
					$k = 1;
					for ($i=0; $i < $k; $i++) { 
						$_FILES["file"]["name"] = $temp[0] . $i . '.' . end($temp);
						if (file_exists(ROOT . "public/img/" . $_FILES["file"]["name"])){
							$k++;
						}else {
							move_uploaded_file($_FILES["file"]["tmp_name"],
							ROOT . "public/img/" . $_FILES["file"]["name"]);
							$echo .="Stored in: " . "public/img/" . $_FILES["file"]["name"];

						}
					}
				} else {
					move_uploaded_file($_FILES["file"]["tmp_name"],
					ROOT . "public/img/" . $_FILES["file"]["name"]);
					$echo .="Stored in: " . "public/img/" . $_FILES["file"]["name"];
				}
			}
		}
		echo $echo;
	}
}
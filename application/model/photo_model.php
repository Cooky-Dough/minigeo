<?php

class PhotoModel
{

	public function getAllPhotos()
	{
		$query = $this->db->prepare('SELECT * FROM photos');
		$query->execute();
		return $query->fetchAll();
	}


	public function addPhoto($file)
	{
		$echo = '';
			$allowedExts = array("jpeg", "jpg", "pjpeg");
			$temp = explode(".", $file["file"]["name"]); 
			$extension = end($temp);

			if ((($file["file"]["type"] == "image/jpeg")
			|| ($file["file"]["type"] == "image/jpg")
			|| ($file["file"]["type"] == "image/pjpeg"))
			&& ($file["file"]["size"] < 20000000)
			&& in_array($extension, $allowedExts)) {
				if ($file["file"]["error"] > 0) {
					$echo .= "Return Code: " . $file["file"]["error"] . "<br>";
				} else {

					$location = $this->getGPSLocation($file);
					if ($location == false)
					{
						$echo = "Er zit geen gps in de foto";
						return $echo;
					}else{

						if (file_exists(ROOT . "public/img/" . $file["file"]["name"])) {
							
							$k = 1;
							for ($i=0; $i < $k; $i++) { 
								$file["file"]["name"] = $temp[0] . $i . '.' . end($temp);
								if (file_exists(ROOT . "public/img/" . $file["file"]["name"])){
									$k++;
								}else {
									$this->moveFile($file, $location);
								}
							}
						} else {
							$this->moveFile($file, $location);
						}
					}
				}
		}
	}

	private function getGPSLocation($file)
	{
		$data = exif_read_data($file["file"]["tmp_name"]);
		
		$latitude = $this->gps($data["GPSLatitude"], $data["GPSLatitudeRef"]);
		$longtitude = $this->gps($data["GPSLongitude"], $data["GPSLongitudeRef"]);
		$gps = array($latitude, $longtitude);
		return $gps;
	}

	private function gps($coordinate, $hemisphere) {
  		for ($i = 0; $i < 3; $i++) {
   			$part = explode('/', $coordinate[$i]);
   			if (count($part) == 1) {
      			$coordinate[$i] = $part[0];
    		} else if (count($part) == 2) {
     			$coordinate[$i] = floatval($part[0])/floatval($part[1]);
    		} else {
      			$coordinate[$i] = 0;
    		}
  		}
  		list($degrees, $minutes, $seconds) = $coordinate;
  		$sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
  		return $sign * ($degrees + $minutes/60 + $seconds/3600);

	}
	private function moveFile($file, $location){
		move_uploaded_file($file["file"]["tmp_name"],
		ROOT . "public/img/" . $file["file"]["name"]);
		$this->addPhotoDB($file["file"]["name"], $location[0], $location[1]);
	}

	private function addPhotoDB($name, $lat, $lon)
	{
		$user_id = Session::get('user_id');
		$sql = $this->db->prepare("INSERT INTO photos (name, lon, lat, user_id ) VALUES (:name, :lon, :lat, :user_id )");
		$sql->execute(array(':name' => $name, ':lat' => $lat, ':lon' => $lon, ':user_id' => $user_id));
	}
}


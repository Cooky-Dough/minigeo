<?php

class Game extends Controller
{

	public function index()
	{
        $this->photo_model = $this->loadModel('photo');

        // getting all songs and amount of songs
        $this->view->photos = $this->photo_model->getAllPhotos();

       // load views. within the views we can echo out $songs and $amount_of_ easily
        $this->view->render('game/index');
	}

	public function scoreboard($km)
	{
		$this->view->km = $km;
		$this->game_model = $this->loadModel('game');
		$this->view->score = $this->game_model->getAllScores();
		$this->view->render('game/scoreboard');
	}


	public function play($id = null)
	{
		$this->game_model = $this->loadModel('game');
		if ($id != null) {
			//database verzoek voor de foto path
			$result = $this->game_model->getPhotoPath($id);
			$name = $result[0];
			$id = $result[1];
		} else {
			$result = $this->game_model->randomPhoto();
			$name = $result[0];
			$id = $result[1];
		}
		$this->view->name = $name;
		$this->view->id = $id;
		$this->view->render('game/play');
	}

	public function getLongLat($id)
	{
	$this->game_model = $this->loadModel("game");
    $location = $this->game_model->getLongLat($id);
    $location = array("lon" => $location->lon, "lat" => $location->lat);
    echo json_encode($location);

	}

	public function score($lat1, $lon1, $lat2, $lon2, $photoid)
	{
	
	$theta = $lon1 - $lon2;
	$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
	$dist = acos($dist);
	$dist = rad2deg($dist);
	$km = $dist * 60 * 1.1515;
	$km * 1.609344;

	header('location: ' . URL . 'game/scoreboard/' . $km);

	$this->game_model = $this->loadModel("game");
	$this->game_model->insertScore($km, $photoid);
	}
}
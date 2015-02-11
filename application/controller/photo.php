<?php
class Photo extends controller{

	public function index()
	{
        $this->photo_model = $this->loadModel('photo');

        // getting all songs and amount of songs
        $this->view->photos = $this->photo_model->getAllPhotos();

       // load views. within the views we can echo out $songs and $amount_of_ easily
        $this->view->render('photo/index');
	}

	public function addPhoto()
	{
		
		$this->photo_model = $this->loadmodel('Photo');
		$this->view->render('photo/upload');
		
		if (isset($_POST['submit_add_photo'])) {
			$this->photo_model->addPhoto($_FILES);	
			header('location: ' . URL . 'photo');
		}

	}
}
<?php

class GameModel
{
	public function getPhotoPath($id)
	{
		$sql = $this->db->prepare("SELECT * FROM photos WHERE id = :id");
		$sql->execute(array(':id' => $id));
		$result = $sql->fetchAll();
		foreach($result as $data){
            $name = $data->name;
            $id = $data->id;
        }
        $result2 = array($name, $id);
        return $result2;
	}

	public function randomPhoto()
	{
		$sql = $this->db->prepare("SELECT * FROM photos ORDER BY RAND() limit 1");
		$sql->execute();
		$result = $sql->fetchAll();
        foreach($result as $data){
            $name = $data->name;
            $id = $data->id;
        }
        $result2 = array($name, $id);
        return $result2;

	}

    public function getLongLat($id)
    {
        $sql = "SELECT lon, lat FROM photos WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute(array(':id' => $id));
        return $query->fetch();
    }

    public function insertScore($km, $photoid)
    {
    	$user_id = Session::get('user_id');
    	$sql = "INSERT INTO score (photo_id, km, user_id) VALUES (:photo_id, :km, :user_id)";
    	$query = $this->db->prepare($sql);
        $query->execute(array(':photo_id' => $photoid, ':km' => $km, ':user_id' => $user_id));
    }

    public function getAllScores()
    {
    	$query = $this->db->prepare('select * from score inner join users on score.user_id = users.user_id inner join photos on score.photo_id = photos.id');
    	$query->execute();
    	return $query->fetchAll();
    }
}
<div> jij zat er <?php echo $this->km; ?> vandaan</div>
<?php foreach ($this->score as $score) {?>
	<p> user <?php echo $score->user_name; ?> zat er <?php echo $score->km ?>km vandaan op foto <img  class = "thumbnail" src = '<?php echo URL . "public/img/" . $score->name ?>'</p>
<?php }; ?>
<a href="<?php echo URL;?>/photo/addphoto">Upload a photo.</a>
<section class="showphoto">
        <?php foreach ($this->photos as $photo) { ?>
            <td>
                <?php if (isset($photo->name)) { ?>
                    <a href = "<?php echo URL . "game/play/" . $photo->id;?>"><img class = "thumbnail" src="./public/img/<?php echo $photo->name; ?>"></a>
                <?php } ?>
            </td>
        <?php } ?>
</section>
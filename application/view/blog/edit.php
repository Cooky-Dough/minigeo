<div class="container">
    <h2>You are in the View: application/view/blog/edit.php (everything in this box comes from that file)</h2>
    <!-- add song form -->
    <div>
        <h3>Edit a Post</h3>
        <form action="<?php echo URL; ?>blog/updatePost" method="POST">
            <label>Auteur</label>
            <input autofocus type="text" name="user" value="<?php echo htmlspecialchars($this->posts->author, ENT_QUOTES, 'UTF-8'); ?>" required />
            <label>Content</label>
            <input type="text" name="content" value="<?php echo htmlspecialchars($this->posts->content, ENT_QUOTES, 'UTF-8'); ?>" required />
            <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($this->posts->id, ENT_QUOTES, 'UTF-8'); ?>" />
            <input type="submit" name="submit_update_post" value="Update" />
        </form>
    </div>
</div>

<div class="container">
    <h2>You are in the View: application/view/blog/index.php (everything in this box comes from that file)</h2>
    <!-- add song form -->
    <div class="box">
        <h3>Add a post.</h3>
        <form action="<?php echo URL; ?>blog/addPost" method="POST">
            <label>Author</label>
            <input type="text" name="author" value="" required />
            <label>Content</label>
            <input type="text" name="content" value="" required />
            <input type="submit" name="submit_add_post" value="Submit" />
        </form>
    </div>
    <!-- main content output -->
    <div class="box">
        <h3>Amount of posts (data from second model)</h3>
        <div>
            <?php echo $this->amount_of_posts; ?>
        </div>
        <h3>List of posts (data from first model)</h3>
        <table>
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Id</td>
                <td>Author</td>
                <td>Content</td>
                <td>DELETE</td>
                <td>EDIT</td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->posts as $post) { ?>
                <tr>
                    <td><?php if (isset($post->id)) echo htmlspecialchars($post->id, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($post->author)) echo htmlspecialchars($post->author, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><?php if (isset($post->content)) echo htmlspecialchars($post->content, ENT_QUOTES, 'UTF-8'); ?></td>
                    <td><a href="<?php echo URL . 'blog/deletepost/' . htmlspecialchars($post->id, ENT_QUOTES, 'UTF-8'); ?>">delete</a></td>
                    <td><a href="<?php echo URL . 'blog/editpost/' . htmlspecialchars($post->id, ENT_QUOTES, 'UTF-8'); ?>">edit</a></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

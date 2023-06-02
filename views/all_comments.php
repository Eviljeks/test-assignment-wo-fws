<?php

declare(strict_types=1);

use App\Model\Comment;

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Form</title>
</head>
<body>
<form action="my_comment.php" method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token'];?>">
    <label for="text">
        Type some text!
    </label>
    <textarea id="text" name="text"></textarea>

    <button type="submit">Submit</button>
</form>
<div>
    <h5>All comments:</h5>
    <p>----------------------------------------</p>

    <?php
    /** @var Comment $comment */
    foreach ($data['comments'] as $comment) {?>
    <div>
        <p>Id: <?php echo $comment->getId(); ?></p>
        <p>Text: <?php echo $comment->getText(); ?></p>
        <p>----------------------------------------</p>
    </div>
    <?php } ?>
</div>

</body>
</html>

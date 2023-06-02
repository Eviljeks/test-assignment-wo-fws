<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>My comment</title>
</head>
<body>
<div>
    <h5>Your comment is saved:</h5>
    <p>----------------------------------------</p>
    <div>
        <p>Id: <?php echo $data['comment']->getId(); ?></p>
        <p>Text: <?php echo $data['comment']->getText(); ?></p>
        <p>----------------------------------------</p>
    </div>
    <a href="all_comments.php">To all comments...</a>
</div>
</body>
</html>


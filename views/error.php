<?php

declare(strict_types=1);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Error occurred</title>
</head>
<body>
<p>
    <?php echo $data['exception']->getCode(); ?>: <?php echo $data['exception']->getMessage(); ?>
</p>
<a href="all_comments.php">To all comments...</a>
</body>
</html>

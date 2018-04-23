<?php

/* Adjust Directory Path For Hosting */
$_SERVER['DOCUMENT_ROOT'] .= '/';

require_once $_SERVER['DOCUMENT_ROOT'] . 'config/conf';
require_once $_SERVER['DOCUMENT_ROOT'] . 'db/database_queries.php';
require_once $_SERVER['DOCUMENT_ROOT'] . 'src/presenter.php';

$table = USERNAMES[0];

try {
    $posts = select($table, ['user_name', 'text', 'image_qualities', 'image_names', 'id'], null, ['timestamp DESC'], 20);
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}

?>

<!------------------------------------------ HTML ------------------------------------------>
<!DOCTYPE html>
<html>
<head>
    <!-- Import Google Icon Font -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Import materialize.css -->
    <link type="text/css" rel="stylesheet" href="src/css/materialize.min.css" media="screen,projection"/>
    <!-- Let browser know website is optimized for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<!-- Navbar -->
<div class="navbar-fixed">
    <nav class="teal lighten-5">
        <div class="nav-wrapper container">
            <a herf="#" class="brand-logo center">
                <img src="/src/images/logo.png" height="56" style="padding-top: 10px">
            </a>
            <!--        <ul id="nav-mobile" class="left hide-on-med-and-down">-->
            <!--            <li><a herf="#">Btn 1</a></li>-->
            <!--            <li><a herf="#">Btn 2</a></li>-->
            <!--            <li><a herf="#">Btn 3</a></li>-->
            <!--        </ul>-->
        </div>
    </nav>
</div>
<!-- Body -->
<div class="container">
    <?php
    foreach ($posts as $post) {
        $imageUris = [];
        if ($post['image_qualities']) {
            $imageNames = json_decode($post['image_names']);
            foreach ($imageNames as $imageName) {
                $imageUris[] = parseImageUri($post['id'], $post['image_qualities'], $imageName);
            }
        }

        echo card($post['text'], $post['user_name'], $imageUris);
    }
    ?>
</div>
<!-- JavaScript at end of body for optimized loading -->
<script type="text/javascript" src="src/js/materialize.min.js"></script>
</body>
</html>

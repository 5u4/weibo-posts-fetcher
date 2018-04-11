<?php

require_once 'conf';
require_once 'database_queries.php';
require_once 'presenter.php';

$table = USERNAMES[0];

try {
    $posts = select($table, ['user_name', 'text', 'image_names', 'id'], null, ['timestamp DESC'], 20);
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
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

    <!-- Let browser know website is optimized for mobile -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body>
<!-- Navbar -->
<nav>
    <div class="nav-wrapper container">
        <a herf="#" class="brand-logo right">Weibo Posts Fetcher</a>
        <ul id="nav-mobile" class="left hide-on-med-and-down">
            <li><a herf="#">Btn 1</a></li>
            <li><a herf="#">Btn 2</a></li>
            <li><a herf="#">Btn 3</a></li>
        </ul>
    </div>
</nav>
<!-- Body -->
<div class="container">
    <?php
    foreach ($posts as $post) {
        echo card($post['text'],$post['user_name']);
    }
    ?>
</div>
<!-- JavaScript at end of body for optimized loading -->
<script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>

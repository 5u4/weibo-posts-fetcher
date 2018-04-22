<?php

/* import credentials */
require_once $_SERVER['DOCUMENT_ROOT'] . 'config/conf';

/* Database Connection */
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);

/* Connect */
if ($db->connect_errno) {
    exit("Unable to connect to database (" . $db->connect_errno . ") " . $db->connect_error."\n");
}

/* Set Charset */
$db->set_charset('utf8mb4');

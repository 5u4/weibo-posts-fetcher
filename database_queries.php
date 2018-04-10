<?php

include_once 'db.inc.php';
include_once 'conf';

/**
 * @param string $tableName
 * @return void
 * @throws Exception
 */
function createTableIfNotExists(string $tableName): void
{
    /* Set columns */
    $columns = '';

    foreach (TABLE_COLUMNS as $key => $value) {
        $columns .= $key . ' ' . $value . ', ';
    }

    foreach (TABLE_COLUMN_CONSTRAINTS as $key => $value) {
        $columns .= $key . ' (' . implode(', ', $value) . '), ';
    }

    $columns = rtrim($columns, ', ');

    /* Build Query */
    $query = "CREATE TABLE IF NOT EXISTS `".$tableName."` (" . $columns . ") DEFAULT CHARSET=utf8mb4;";

    /* Create Table */
    databaseQuery($query);
}

/**
 * @param string $table
 * @param array $values
 * @return void
 * @throws Exception
 */
function insertIntoTable(string $table, array $values): void
{
    /* Columns + Values */
    $_values = '';
    $columns = '';

    foreach ($values as $key => $value) {
        $columns .= "" . $key . ", ";
        $_values .= "'" . $value . "', ";
    }

    $columns = rtrim($columns, ', ');
    $_values = rtrim($_values, ', ');

    /* Build Query */
    $query = "INSERT INTO `" . $table . "` (" . $columns . ") VALUES (" . $_values . ")";

    /* Insert Table */
    databaseQuery($query);
}

/**
 * Execute database query
 *
 * @param string $query
 * @return void
 * @throws Exception
 */
function databaseQuery(string $query)
{
    global $db;

    if (!$db->query($query)) {
        throw new Exception($query . "\n" . mysqli_error($db) . " \n");
    }
}

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
 * @param string $table
 * @param array $selectedColumns
 * @param array|null $whereClauses
 * @return array
 * @throws Exception
 */
function select(string $table, array $selectedColumns, array $whereClauses = null): array
{
    /* Columns */
    $selectedColumns = implode(', ', $selectedColumns);

    /* Where Clauses */
    if (isset($whereClauses)) $whereClauses = implode(' AND ', $whereClauses);

    /* Build Query */
    $query = "SELECT " . $selectedColumns . " FROM " . $table;
    if (isset($whereClauses)) $query .= " WHERE " . $whereClauses;

    /* Select */
    return databaseQuery($query, true);
}

/**
 * Execute database query
 *
 * @param string $query
 * @param bool $expectReturn
 * @return array
 * @throws Exception
 */
function databaseQuery(string $query, bool $expectReturn = false): array
{
    global $db;

    $result = $db->query($query);

    if (!$result) {
        throw new Exception(mysqli_error($db) . " \n" . $query . "\n\n");
    }

    if ($expectReturn) {
        $formattedResult = [];
        for ($counter = 0; $counter < $result->num_rows; $counter++) {
            $formattedResult[] = mysqli_fetch_assoc($result);
        }

        return $formattedResult;
    }

    return [];
}

/**
 * @param string $message
 * @return bool
 */
function isDuplicateEntry(string $message): bool
{
    $duplicateMessage = 'Duplicate entry';

    return substr($message, 0, strlen($duplicateMessage)) == $duplicateMessage;
}

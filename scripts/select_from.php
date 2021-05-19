<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();

if (isset($_GET['tablename']))
{
    $tablename = $_GET['tablename'];

    $result = $db->selectFrom($tablename);

    echo json_encode($result);
}

<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();

if (isset($_POST['tablename']) && isset($_POST['values']) && isset($_POST['id']))
{
    $tablename = $_POST['tablename'];
    $values = $_POST['values'];
    $id = $_POST['id'];

    $result = $db->updateTable($tablename, $values, $id);

    if ($result === true) {
        header('Location: ../index.php?update=1');
    }
    else{
        header('Location: ../index.php?update=0&error=error');
    }
}

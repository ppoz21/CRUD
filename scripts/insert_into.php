<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();

if (isset($_POST['tablename']) && isset($_POST['values']))
{
    $tablename = $_POST['tablename'];
    $values = $_POST['values'];

    $result = $db->insertInto($tablename, $values);

    if ($result === true) {
        header('Location: ../index.php?insertInto=1');
    }
    else{
        header('Location: ../index.php?insertInto=0&error=error');
    }
}

<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();

if (isset($_GET['tablename']) && isset($_GET['id'])) {

    $tablename = $_GET['tablename'];
    $id = $_GET['id'];

    $result = $db->deleteOnce($tablename, $id);

    if ($result === true) {
        header('Location: ../index.php?removeOne=1');
    }
    else{
        header('Location: ../index.php?removeOne=0&error=error');
    }
}

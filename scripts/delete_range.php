<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();

if (isset($_GET['tablename']) && isset($_GET['idmin']) && isset($_GET['idmax'])) {

    $tablename = $_GET['tablename'];
    $idMin = $_GET['idmin'];
    $idMax = $_GET['idmax'];

    $result = $db->deleteRange($tablename, $idMin, $idMax);

    if ($result === true) {
        header('Location: ../index.php?removeRange=1');
    }
    else{
        header('Location: ../index.php?removeRange=0&error=error');
    }
}

<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();

if (isset($_GET['name']))
{
    $tablename = $_GET['name'];
    $result = $db->dropTable($tablename);

    if ($result === true)
        header('Location: ../index.php?droptable=1');
    else
        header('Location: ../index.php?droptable=0&error='.$result);
}
else
    header('Location: ../index.php');

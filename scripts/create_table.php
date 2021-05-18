<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();


if (isset($_POST['tablename']) && isset($_POST['fields']))
{
    $tablename = $_POST['tablename'];
    $fields = $_POST['fields'];

    $tempArrFull = [];

    foreach ($fields as $field)
    {
        $tempArr = [];
        array_push($tempArr, $field['name']);
        $tempType = $field['type'];
        $type = match ($tempType) {
            '0' => 'int',
            '1' => 'varchar(255)',
            '2' => 'text',
        };

        array_push($tempArr, $type);

        if (isset($field['notnull']))
            array_push($tempArr, 'not null');
        else
            array_push($tempArr, 'null');

        array_push($tempArrFull, $tempArr);

    }

    $result = $db->createTable($tablename, $tempArrFull);

    if ($result === true)
        header('Location: ../index.php?addtable=1');
    else
        header('Location: ../index.php?addtable=0&error='.$result);

}
else
{
    header('Location: ../index.php?addtable=0');
}


<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();

if (isset($_GET['tablename']))
{
    $tablename = $_GET['tablename'];

    $cols = $db->getCols($tablename);

    echo <<< EOF
<div class="row">
<div class="col-12">
<form method="post" action="./scripts/insert_into.php">
    
    <input type="hidden" name="tablename" value="$tablename">

EOF;
    $i = 0;
    foreach ($cols as $col)
    {
        if ($col["column_name"] == 'id')
            continue;
        if ($col["data_type"] == 'text')
            echo "<div class='mb-3'><label class='d-flex flex-column'>" . $col["column_name"] . " <textarea class='form-control' name='values[". $i ."]'> </textarea></label></div>";
        else
        {

            $type =  match ($col["data_type"])
            {
                'integer' => 'number',
                'character varying' => 'text'
            };
            echo "<div class='mb-3'><label class='d-flex flex-column'>" . $col["column_name"] . " <input class='form-control' type='". $type ."' name='values[". $i ."]'></label></div>";
        }
        $i++;
    }

    echo <<< EOF
    <div class="mb-3">
        <input type="submit" class="btn btn-success" value="Dodaj dane">
    </div>
</form>
</div>
</div>
EOF;


}

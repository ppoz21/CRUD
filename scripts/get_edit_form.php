<?php

require_once('../class/Database.php');

use App\class\Database;

$db = new Database();

if (isset($_GET['tablename']) && isset($_GET['id'])) {
    $tablename = $_GET['tablename'];
    $id = $_GET['id'];

    $cols = $db->getCols($tablename);

    $values = $db->selectFromWhereId($tablename, $id);

    echo <<< EOF
<div class="row">
<div class="col-12">
<form method="post" action="./scripts/update.php">
    
    <input type="hidden" name="tablename" value="$tablename">
    <input type="hidden" name="id" value="$id">

EOF;
    $i = 0;
    foreach ($cols as $col) {
        $colname = $col["column_name"];
        $val =  $values[0][$colname];
        if ($col["column_name"] == 'id')
            continue;
        if ($col["data_type"] == 'text')
            echo "<div class='mb-3'><label class='d-flex flex-column'>" . $colname . " <textarea class='form-control' name='values[" . $colname . "]'> $val </textarea></label></div>";
        else {

            $type = match ($col["data_type"]) {
                'integer' => 'number',
                'character varying' => 'text'
            };
            echo "<div class='mb-3'><label class='d-flex flex-column'>" . $colname . " <input class='form-control' type='" . $type . "' name='values[" . $colname . "]' value='$val'></label></div>";
        }
        $i++;
    }

    echo <<< EOF
    <div class="mb-3">
        <input type="submit" class="btn btn-success" value="Edytuj dane">
    </div>
</form>
</div>
</div>
EOF;

}

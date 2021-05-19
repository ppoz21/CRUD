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
    foreach ($cols as $col)
    {
        if ($col["data_type"] == 'text')
            echo "<div class='mb-3'><label class='d-flex flex-column'>" . $col["column_name"] . " <textarea class='form-control' name='". $col["column_name"] ."'> </textarea></label></div>";
        else
            echo "<div class='mb-3'><label class='d-flex flex-column'>" . $col["column_name"] . " <input class='form-control' type='". match ($col["data_type"]) {'integer' => 'number', 'character varying' => 'text' } ."' name='". $col["column_name"] ."'></label></div>";
    }

    echo <<< EOF

</form>
</div>
</div>
EOF;


}

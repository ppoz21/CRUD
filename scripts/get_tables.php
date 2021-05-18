<?php

require_once('./class/Database.php');

use App\class\Database;

$db = new Database();

$tables = $db->listTables();

?>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Nazwa tabeli</th>
        <th scope="col">Liczba wierszy</th>
        <th scope="col">Usuń tabelę</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sumaWierszy = 0;
    foreach ($tables as $table)
    {
        echo "<tr><td>$table[0]</td><td>$table[1]</td><td> <a href='./scripts/drop_table.php?name=$table[0]' class='text-danger'>Usuń</a></td></tr>";
        $sumaWierszy += $table[1];
    }
    ?>
    </tbody>
</table>

<p class="h4">Ilość tabel: <?php echo count($tables) ?></p>
<p class="h4">Suma wierszy: <?php echo $sumaWierszy ?></p>

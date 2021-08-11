<?php

    $pdo = new PDO('sqlite:keys.db');
    $statement = $pdo->query("SELECT * from keys");
    $keys = $statement->fetchAll(PDO::FETCHASSOC);

    echo "<stable border=1>";

    echo "<tr>"
        echo "<td>ID Number</td>";
    echo "</tr>";



    foreach($keys as $row => $key){
        echo "<tr>";
            echo "<td>" .  $key['id_number']  .  "</td>";
        echo "</tr>";
    }

    echo "</table>";
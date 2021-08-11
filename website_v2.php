<?php

    $pdo = new PDO('sqlite:keys.db');
    $statement = $pdo->query("SELECT * from keys");
    $keys = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border=1>";

    echo "<tr>";
        echo "<td>Key Number</td>";
        echo "<td>Address</td>td>";
    echo "</tr>";



    foreach($keys as $row => $key){
        echo "<tr>";
            echo "<td>" .  $key['id_number']  .  "</td>";
            echo "<td>" .  $key['site_address']  .  "</td>";
        echo "</tr>";
    }

    echo "</table>";
<html>
<head>
    <title>Title</title>
    <style>
        table, tr, td {
            margin: 8px;
            border: 2px solid black;
        }
    </style>
</head>
<body>

<?php

    $pdo = new PDO('sqlite:keys.db');
    $statement = $pdo->query("SELECT * from keys");
    $keys = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "<table>";

    echo "<tr>";
        echo "<td>Key Number</td>";
        echo "<td>Address</td>";
        echo "<td>Who Has It?</td>";
    echo "</tr>";



    foreach($keys as $row => $key){
        echo "<tr>";
            echo "<td>" .  $key['id_number']  .  "</td>";
            echo "<td>" .  $key['site_address']  .  "</td>";
            echo "<td>" .  $key['key_holder']  .  "</td>";
        echo "</tr>";
    }

    echo "</table>";
?>
</body>
</html>
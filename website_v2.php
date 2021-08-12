<html>
<head>
    <title>Da keys</title>
    <style>
        table, tr, td {
            border: 2px solid black;
            border-collapse: collapse;

        }
        table {
            width: 75%;
            margin: 200px auto;
        }

        tr {
            height: 30px;
            font-size: 23px;
        }

        td {
            font-size: 25px;
        }

        h1 {
            font-size: 300px;
            text-align: center;
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;

        }
    </style>
</head>
<body>
<h1>
    Da Keys
</h1>

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
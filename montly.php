<html>
<head>
    <title>Monthlies </title>
    <style>
        body {
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            background: #1f1f1f;
            color: #fafafa;
        }

        table, tr, td {
            border: none;
            border-collapse: collapse;

        }
        tr:nth-child(even) {
            background-color: #5c5c5c;
        }

        table {
            width: 90%;
            margin: 100px auto;
            text-align: center;
        }

        tr {
            height: 30px;
            font-size: 23px;
        }

        td {
            font-size: 28px;
        }

        td.fip {
            width: 75px;
        }

        h1 {
            font-size: 100px;
            text-align: center;
            color: #ff0033
        }
        h2 {
            font-size: 30px;
        }

        h3 {
            font-size: 20px;
        }
        input {
            font-size: 30px;
            resize: none;
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            width: 100%;

        }

        input.check {
            height: 85%;
        }
    </style>
</head>

<h1>
    Montlies
</h1>
















</html>

<?php

$pdo = new PDO('sqlite:keys.db');
$statement = $pdo->query("SELECT * from keys WHERE ");
$keys = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<table>";

echo "<tr>";
echo "<td><h2>Monthly Done?</h2></td>";
echo "<td><h2>Address</h2></td>";
echo "<td><h2>Access Details</h2></td>";
echo "<td><h2>Is There A Key?</h2></td>";
echo "</tr>";



foreach($keys as $row => $key){
    echo "<tr><h3>";
    echo "<td>" .  $key['fip']  .  "</td>";
    echo "<td>" .  $key['address']  .  "</td>";
    echo "<td>" .  $key['access']  .  "</td>";
    echo "<td>" .  $key['is_key']  .  "</td>";
    echo "</h3></tr>";
}

echo "</table>";
?>
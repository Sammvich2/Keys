<html>
<head>
    <title>Key Entry</title>
    <style>
        body {
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            background: #1f1f1f;
            color: #fafafa;
        }

        table, tr, td {
            border: 2px solid black;
            border-collapse: collapse;

        }
        table {
            width: 75%;
            margin: -100px auto;
        }

        tr {
            height: 30px;
            font-size: 23px;
        }

        td {
            font-size: 28px;
        }

        h1 {
            font-size: 300px;
            text-align: center;
            color: #ff0033
        }
        h2 {
            font-size: 30px;
        }

        h3 {
            font-size: 20px;
        }
    </style>
</head>
<body>
<h1>

</h1>


<?php


$pdo = new PDO('sqlite:keys.db');
$statement = $pdo->query("SELECT * from keys");
$keys = $statement->fetchAll(PDO::FETCH_ASSOC);

echo "<table>";

echo "<tr>";
echo "<td><h2>Key Number</h2></td>";
echo "<td><h2>Address</h2></td>";
echo "<td><h2>Who Has It?</h2></td>";
echo "<td><h2>Issuer</h2></td>";
echo "<td><h2>Large?</h2></td>";
echo "<td><h2>FIP Monthly</h2></td>";
echo "<td><h2>Pump Monthly</h2></td>";
echo "<td><h2>Access Details</h2></td>";
echo "<td><h2>Key?</h2></td>";
echo "</tr>";


foreach ($keys as $row => $key) {
    echo "<tr><h3>";
    echo "<td>" . $key['id_number'] . "</td>";
    echo "<td>" . $key['site_address'] . "</td>";
    echo "<td>" . $key['key_holder'] . "</td>";
    echo "<td>" . $key[''] . "</td>";
    echo "</h3></tr>";
}

echo "</table>";
?>
</body>
</html>
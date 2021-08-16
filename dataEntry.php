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

<table>

    <tr>
        <th><h2>Key Number</h2></th>
        <th><h2>Address</h2></th>
        <th><h2>Who Has It?</h2></th>
        <th><h2>When?</h2></th>
        <th><h2>Issuer</h2></th>
        <th><h2>Large?</h2></th>
        <th><h2>FIP Monthly</h2></th>
        <th><h2>Pump Monthly</h2></th>
        <th><h2>Access Details</h2></th>
        <th><h2>Key?</h2></th>
    </tr>
    <tr>
        <td><textarea</td>



    </tr>

</table>

<?php


$pdo = new PDO('sqlite:keys.db');
$statement = $pdo->query("SELECT * from keys");
$keys = $statement->fetchAll(PDO::FETCH_ASSOC);




foreach ($keys as $row => $key) {
    echo "<tr><h3>";
    echo "<td>" . $key['id_number'] . "</td>";
    echo "<td>" . $key['address'] . "</td>";
    echo "<td>" . $key['key_holder'] . "</td>";
    echo "<td>" . $key['date_of_issue'] . "</td>";
    echo "<td>" . $key['key_provider'] . "</td>";
    echo "<td>" . $key['large'] . "</td>";
    echo "<td>" . $key['fip'] . "</td>";
    echo "<td>" . $key['pump'] . "</td>";
    echo "<td>" . $key['access'] . "</td>";
    echo "<td>" . $key['is_key'] . "</td>";
    echo "</h3></tr>";
}

echo "</table>";
?>
</body>
</html>

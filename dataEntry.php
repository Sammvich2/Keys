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

<pre>
    <?php
        if ($_POST['submit'])



    ?>
</pre>


<body>

<table>

    <tr>
        <td><h2>Key ID</h2></td>
        <td><h2>Address</h2></td>
        <td><h2>Who?</h2></td>
        <td><h2>When?</h2></td>
        <td><h2>Issuer</h2></td>
        <td><h2>Large?</h2></td>
        <td class="fip"><h2>FIP</h2></td>
        <td><h2>Pump</h2></td>
        <td><h2>Access Details</h2></td>
        <td><h2>Key?</h2></td>
    </tr>
        <form action="dataEntry.php" method="post">
            <tr>
                <td><input type="number" name="keyID"></td>
                <td><input type="text" name="address"></td>
                <td><input type="text" name="who"></td>
                <td><input type="date" name="when"></td>
                <td><input type="text" name="issuer"></td>
                <td><input type="checkbox"  class="check" name="large"></td>
                <td><input type="checkbox" class="check" name="fip"></td>
                <td><input type="checkbox" class="check" name="pump"></td>
                <td><input type="text" name="access"></td>
                <td><input type="checkbox" class="check" name="is_key"></td>
                <td><input type="submit" value="Submit" name="submit"></td>
            </tr>
        </form>
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

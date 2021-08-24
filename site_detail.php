<html>
<head>
    <title>Site Details</title>
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
            background-color: #454545;
        }

        table {
            width: 100%;
            margin: 100px auto;
        }

        tr {
            height: 30px;
        }

        td {
            font-size: 28px;
        }

        h1 {
            font-size: 150px;
            text-align: center;
            color: #ff0033
        }
        h2 {
            font-size: 45px;
        }

        h3 {
            font-size: 45px;
        }
    </style>
</head>
<body>
<h1>
    Site Details
    <br>
    <button style="font-size: 25px; text-align: center" id="myButton">Back To Monthlies</button>

    <script type="text/javascript">
        document.getElementById("myButton").onclick = function () {
            location.href = "monthly.php";
        };
    </script>

</h1>

<?php

if(!isset($_COOKIE['sessionID'])) {
    print_r("Write function to return to login");
    echo "<script> setTimeout(function() {
                    window.location.href = 'home.php';
                }, 500);</script>";
} else {



    $pdo = new PDO('sqlite:keys.db');
    $statement = $pdo->query("SELECT * from keys WHERE ");
    $keys = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo "<table>";

    echo "<tr>";
    echo "<td><h2>Address</h2></td>";
    echo "<td style='text-align: center'><h2>Key?</h2></td>";
    echo "<td style='text-align: center'><h2>Who Has It?</h2></td>";
    echo "<td><h2>Access Details</h2></td>";
    echo "</tr>";


    foreach ($keys as $row => $key) {
        echo "<tr><h3>";
        echo "<td>" . $key['address'] . "</td>";
        echo "<td style='text-align: center'>" . $key['is_key'] . "</td>";
        echo "<td style='text-align: center'>" . $key['key_holder'] . "</td>";
        echo "<td>" . $key['access'] . "</td>";
        echo "</h3></tr>";
    }

    echo "</table>";
}



?>
</body>
</html>

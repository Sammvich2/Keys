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
            font-size: 60px;
            margin-top: 3%;
        }

        h3 {
            font-size: 50px;
            color: #dfdfdf;
            margin-top: -3%;
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

<form action="site_detail.php" method="post"><input type="submit" id="monthly" value="Toggle Monthly Status" </form>

<?php

if(!isset($_COOKIE['sessionID'])) {
    print_r("Write function to return to login");
    echo "<script> setTimeout(function() {
                    window.location.href = 'home.php';
                }, 500);</script>";
} else {

    $input = $_POST['done'];
    if ($input) {
        $pdo = new PDO('sqlite:keys.db');
        $statement = $pdo->query("SELECT * from keys WHERE id_number = " . $input);
        $keys = $statement->fetchAll(PDO::FETCH_ASSOC);



        foreach ($keys as $row => $key) {

            echo "< ";
            echo "<h2>FIP Monthly Done?</h2><h3>";
            echo   $key['fip'];

            echo "</h3><h2>Address:</h2><h3>";
            echo   $key['address'];

            echo "</h3><h2>Access Details:</h2><h3>";
            echo $key['access'];

            echo "</h3><h2>Building Manager Details:</h2><h3>";
            echo $key['bm'];

            echo "</h3><h2>Is there a key?</h2><h3>";
            echo $key['is_key'];

            echo "</h3><h2>Who Has It?</h2><h3>";
            echo $key['key_holder'];
            echo "</h3>";


        }

        echo "</table>";
    } else {
        echo "<script> setTimeout(function() {
                window.location.href = 'monthly.php';
            }, 500);</script>";
    }
}



?>
</body>
</html>

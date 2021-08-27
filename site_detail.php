<!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$pdo = new PDO('sqlite:keys.db');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if(!isset($_COOKIE['sessionID'])) {
    print_r("Write function to return to login");
    echo "<script> setTimeout(function() {
                    window.location.href = 'home.php';
                }, 500);</script>";
    } else {
    try {
        $sessionState = $pdo->query("SELECT * from people WHERE id IS " . $_COOKIE['sessionID']);
        $session = $sessionState->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Account Error");
    }
}


if(isset($_POST['site'])) {
    $site = $_POST['site'];

    $cookie_name = "site";
    setcookie($cookie_name, $site, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => '127.0.0.1',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);
} elseif(isset($_POST['monthly'])) {
    $site = $_COOKIE['site'];

    $monthlyStatement = $pdo->query("SELECT * from keys WHERE id_number IS " . $site);
    $monthly = $monthlyStatement->fetch(PDO::FETCH_ASSOC);
    #print_r($done['address']);

    if ($monthly['fip'] == "Yes") {
        $change = $pdo->query("UPDATE keys SET fip = 'No' WHERE id_number IS " . $site);
        $change = $pdo->query("UPDATE keys SET monthly = NULL WHERE id_number IS " . $site);

        echo "<script> setTimeout(function() {
                window.location.href = window.location.pathname;
            }, 500);</script>";
    } elseif ($monthly['fip'] == "No") {
        $change = $pdo->query("UPDATE keys SET fip = 'Yes' WHERE id_number IS " . $site);
        $change = $pdo->query("UPDATE keys SET monthly = '" . $session['account'] . "' WHERE id_number IS " . $site);
        echo "<script> setTimeout(function() {
                window.location.href = window.location.pathname
            }, 500);</script>";
} elseif (isset($_COOKIE['site'])) {
    $site = $_COOKIE['site'];
} else{
    print_r("If you see this, what on earth did you do to cause this error???");
}

?>


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


<table>
<?php


if (isset($site)) {
    try {
        $statement = $pdo->query("SELECT * from keys WHERE id_number = " . $site);
        $keys = $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Site not found in database");
    }

    foreach ($keys as $row => $key) {

        echo "<form action='site_detail.php' id='monthly' method='post'><input type='submit' name='monthly' value='Toggle Monthly Status'></form>";
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
} else {
    die("Site not found");
}
?>


</table>
</body>
</html>

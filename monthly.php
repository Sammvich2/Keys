<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if(!isset($_COOKIE['sessionID'])) {
    print_r("Bye Bye Nerd ;)");
    echo "<script> setTimeout(function() {
                window.location.href = 'index.php';
            }, 500);</script>";
}
if (isset($_COOKIE['site'])) {
    $cookie_name = "site";
    $site = 0;
    setcookie($cookie_name, $site, [
        'expires' => time() + 86400,
        'path' => '/',
        'domain' => 'dakeys.net',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'None',
    ]);
}

$pdo = new PDO('sqlite:keys.db');
?>
<html>
<head>
    <title>Monthlies</title>

    <style>
        body {
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            background: #1f1f1f;
            color: #fafafa;
        }

        table, tr, td {

            border-collapse: collapse;

        }
        tr:nth-child(odd) {
            background-color: #454545;
        }

        table {
            width: 100%;
            margin: 100px auto;
            text-align: center;
        }

        tr {
            height: 30px;
            font-size: 35px;
        }

        td {
            font-size: 28px;
        }

        td.fip {
            width: 75px;
        }

        h1 {
            font-size: 150px;
            text-align: center;
            color: #ff0033;
            padding-bottom: -10%;
        }
        h2 {
            font-size: 45px;
        }

        h3 {
            font-size: 45px;
        }

        h4 {
            font-size: 25px;
            resize: none;
            text-align: center;
            padding-bottom: -10%;
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;

        }

        input {
            font-size: 25px;
            resize: none;
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;

        }
        button {
            font-size: 30px;
            resize: none;
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;

        }
    </style>

    <script type="text/javascript">
        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
        function button() {
            location.href = 'monthly_admin.php'
        }
    </script>

</head>


<body>

    <h1>
        Bumthlies
        <br>
        <button style="font-size: 35px; text-align: center" onclick="location.href = 'site_lookup.php'">Go To Site Lookup</button>
    </h1>

<table>
    <tr>
        <td style="background-color: #1f1f1f">
                <form action="monthly.php" method="post">
                    <input style="padding-top: 1%; font-size: 30px" type="submit" value="Hide Yes" name="hide">
                </form>
        </td>
        <td style="background-color: #1f1f1f">
            <?php
            $adminCheck = $pdo->query("SELECT * from people WHERE id IS '" . $_COOKIE['sessionID'] . "'");
            $admin = $adminCheck->fetch(PDO::FETCH_ASSOC);
            if ($admin['admin'] > 0) {
                echo "<button style='font-size: 30px; text-align: center' onclick='button()'>Go To Admin</button>";
            }
            ?>
        </td>
        <td>
            <form action="monthly.php" method="post">
                <input type="text" placeholder="Search Address" name="search">
                <input type="submit" name="searchSub" value="Search">
            </form>
        </td>

    </tr>

    <tr>
        <td style="width: 10%"><h2>Done?</h2></td>
        <td style="padding-left: 5%; text-align: left"><h2>Address</h2></td>
        <td style="text-align: left; padding-left: 5%"><h2>Access Details</h2></td>
        <td style="width: 10%"><h2>Key?</h2></td>
    </tr>


    <?php
    #ini_set('display_errors', 1);
    #ini_set('display_startup_errors', 1);
    #error_reporting(E_ALL);
    if ($_POST['searchSub'] == "Search") {
        $statement = $pdo->query("SELECT * from keys WHERE address LIKE '" . $_POST['search'] . "'");
    } elseif ($_POST['hide'] == "Hide Yes") {
            #print_r($_POST);
        $statement = $pdo->query("SELECT * from keys WHERE fip IS 'No' ORDER BY address ASC");
    } else {
        $statement = $pdo->query("SELECT * from keys WHERE fip IS NOT NULL ORDER BY address ASC");
    }

        $keys = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach($keys as $row => $key){
            echo "<tr><h3>";
            echo "<td style='padding-top: 1%; padding-bottom: 1%'>" .  $key['fip']  .  "</td>";
            echo "<td style='text-align: left; padding-left: 5%'>" .  $key['address']  .  "</td>";
            echo "<td style='text-align: left; padding-left: 5%'>" .  $key['access']  .  "</td>";
            echo "<td>" .  $key['is_key']  .  "</td>";
            echo "<td style='padding-top: 1%'><form action='site_detail.php' id='site' method='post'><input name='site' type='submit' value=" . $key['siteID'] . "></form></td>";
            echo "</h3></tr>";
        }
        if ($_POST['searchSub'] == "Search") {
            $statement = $pdo->query("SELECT * from keys WHERE address LIKE '" . $_POST['search'] . "'");
        }
    ?>

</table>
</body>
</html>


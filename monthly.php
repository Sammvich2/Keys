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
    </style>

    <script type="text/javascript">
        document.getElementById("myButton").onclick = function () {
            location.href = "site_lookup.php";
        };


        if ( window.history.replaceState ) {
            window.history.replaceState( null, null, window.location.href );
        }
    </script>

</head>


<body>

    <h1>
        The Clock Is Ticking
        <br>
        <button style="font-size: 25px; text-align: center" id="myButton">Go To Site Lookup</button>
    </h1>

<table>
    <tr>
        <td style="background-color: #1f1f1f">
                <form action="monthly.php" method="post">
                    <input style="padding-top: 1%" type="submit" value="Hide Yes" name="hide">
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
    $pdo = new PDO('sqlite:keys.db');
    if ($_POST['hide'] == "Hide Yes") {
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
            echo "<td style='padding-top: 1%'><form action='monthly.php' id='done' method='post'><input onclick='timeFunction()' name='done' type='submit' value=" . $key['id_number'] . "></form></td>";
            echo "</h3></tr>";
        }



    if ($_POST['done']) {
        #print_r($_POST['done']);
        #$pdo = new PDO('sqlite:keys.db');
        $doneStatement = $pdo->query("SELECT * from keys WHERE id_number IS " . $_POST['done']);
        $done = $doneStatement->fetch(PDO::FETCH_ASSOC);
        #print_r($done['address']);

        if ($done['fip'] == "Yes") {
            $change = $pdo->query("UPDATE keys SET fip = 'No' WHERE id_number IS " . $_POST['done']);
            $_POST == null;
            echo "<script> setTimeout(function() {
                window.location.href = window.location.pathname;
            }, 5000);</script>";
        } elseif ($done['fip'] == "No") {
            $change = $pdo->query("UPDATE keys SET fip = 'Yes' WHERE id_number IS " . $_POST['done']);
            $_POST == null;
            echo "<script> setTimeout(function() {
                window.location.reload(true)
            }, 5000);</script>";
        } else {
            print_r("Update Failed!");
        }


    }

    ?>

</table>
</body>

<script>

</script>

</html>


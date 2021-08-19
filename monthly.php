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
            border-color: white;
            border-width: 5px;
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

        h4 {
            font-size: 15px;
        }
        input {
            font-size: 20px;
            resize: none;
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            width: 100%;

        }

        input.check {
            height: 85%;
        }
    </style>
</head>
<body>

<h1>
    The Clock Is Ticking
</h1>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>


<table>
    <tr>
        <td><h4><form action="monthly.php" method="post"><input type="submit" value="Hide Yes" name="hide"></form></h4></td>
    </tr>

    <tr>
        <td style="width: 10%"><h2>Monthly Done?</h2></td>
        <td style="padding-left: 5%; text-align: left"><h2>Address</h2></td>
        <td style="text-align: left"><h2>Access Details</h2></td>
        <td style="width: 10%"><h2>Is There A Key?</h2></td>
    </tr>



    <?php
    if ($_POST['hide'] == "Hide Yes") {
        #print_r($_POST);

        $pdo = new PDO('sqlite:keys.db');
        $statement = $pdo->query("SELECT * from keys WHERE fip IS 'No'");
        $keys = $statement->fetchAll(PDO::FETCH_ASSOC);


        foreach($keys as $row => $key){
            echo "<tr><h3>";
            echo "<td>" .  $key['fip']  .  "</td>";
            echo "<td style='text-align: left; padding-left: 5%'>" .  $key['address']  .  "</td>";
            echo "<td style='text-align: left'>" .  $key['access']  .  "</td>";
            echo "<td>" .  $key['is_key']  .  "</td>";
            echo "</h3></tr>";
        }

        echo "</table>";
    } else {
        $pdo = new PDO('sqlite:keys.db');
        $statement = $pdo->query("SELECT * from keys WHERE fip IS NOT NULL");
        $keys = $statement->fetchAll(PDO::FETCH_ASSOC);


        foreach($keys as $row => $key){
            echo "<tr><h3>";
            echo "<td>" .  $key['fip']  .  "</td>";
            echo "<td style='text-align: left; padding-left: 5%'>" .  $key['address']  .  "</td>";
            echo "<td>" .  $key['access']  .  "</td>";
            echo "<td>" .  $key['is_key']  .  "</td>";
            echo "</h3></tr>";
        }

        echo "</table>";
    }
    ?>


</body>

</html>


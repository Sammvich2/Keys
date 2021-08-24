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
            border: none;
            border-collapse: collapse;

        }
        tr:nth-child(even) {
            background-color: #5c5c5c;
        }

        table.keys {
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

        table.input {
            width: 50%;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
            margin-top: -15%;
        }

        tr.input {
            background-color: #1f1f1f;
        }

        td.label {
            text-align: right;
        }

        label {
            text-align: right;
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
            font-size: 25px;
            resize: none;
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            width: 85%;
            height: 80%;

        }

        input.check {
            height: 80%;
        }
    </style>
</head>

<h1>
    Key Admin
</h1>

<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>

<pre>
    <?php
        if ($_POST['submit'] == "Submit") {

            # $query = "INSERT INTO keys (id_number, address, key_holder, date_of_issue, key_provider,
                  # large, fip, pump, access, is_key) values ('$_POST[keyID]', '$_POST[address]','$_POST[who]',
                        # '$_POST[when]', '$_POST[issuer]', '$_POST[large]', '$_POST[fip]', '$_POST[pump]',
                                # '$_POST[access]', '$_POST[is_key]',)";
            # print_r($_POST);

            try {


                $db = new PDO('sqlite:keys.db');
                $sql = "INSERT INTO keys (id_number, address, key_holder, date_of_issue, key_provider, large, fip, pump, access, is_key) VALUES (:id_number, :address, :key_holder, :date_of_issue, :key_provider, :large, :fip, :pump, :access, :is_key)";
                $stmt = $db->prepare($sql);

                $id_number = filter_input(INPUT_POST, 'id_number');
                $stmt->bindValue(':id_number', $id_number, PDO::PARAM_INT);

                $address = filter_input(INPUT_POST, 'address');
                $stmt->bindValue(':address', $address, PDO::PARAM_STR);

                $key_holder = filter_input(INPUT_POST, 'key_holder');
                $stmt->bindValue(':key_holder', $key_holder, PDO::PARAM_STR);

                $date_of_issue = filter_input(INPUT_POST, 'date_of_issue');
                $stmt->bindValue(':date_of_issue', $date_of_issue, PDO::PARAM_STR);

                $key_provider = filter_input(INPUT_POST, 'key_provider');
                $stmt->bindValue(':key_provider', $key_provider, PDO::PARAM_STR);

                #$large = filter_input(INPUT_POST, 'large');
                if ($_POST['large'] == "on"){
                        $large = "Yes";
                    } else {
                        $large = "No";
                }
                $stmt->bindValue(':large', $large, PDO::PARAM_STR);

                #$fip = filter_input(INPUT_POST, 'fip');
                if ($_POST['fip'] == "on"){
                    $fip = "Yes";
                } else {
                    $fip = null;
                }
                $stmt->bindValue(':fip', $fip, PDO::PARAM_STR);

                #$pump = filter_input(INPUT_POST, 'pump');
                if ($_POST['pump'] == "on"){
                    $pump = "Yes";
                } else {
                    $pump = null;
                }
                $stmt->bindValue(':pump', $pump, PDO::PARAM_STR);

                $access = filter_input(INPUT_POST, 'access');
                $stmt->bindValue(':access', $access, PDO::PARAM_STR);

                #$is_key = filter_input(INPUT_POST, 'is_key');
                if ($_POST['is_key'] == "on"){
                    $is_key = "Yes";
                } else {
                    $is_key = "No";
                }
                $stmt->bindValue(':is_key', $is_key, PDO::PARAM_STR);

                $success = $stmt->execute();
                if($success){
                    echo "Key Added To Database";
                } else{
                    echo "Something Went Wrong";
                }

                $db = null;


            } catch (PDOException $e){
                print "Error: " . $e->getMessage() . "br/>";
            }


        }



    ?>
</pre>


<body>

<table class="input">
<form action="dataEntry.php" method="post">


    <tr class="input"><td class="label"><label for="address">Address</label></td>
    <td><input type="text" name="address"></td></tr>
    <br><br>

    <tr class="input"><td class="label"><label for="access">Access Details:</label></td>
    <td><input type="text" name="access"></td></tr>
    <br><br>

    <tr class="input"><td class="label"><label for="bm">Building Manager Details</label></td>
    <td><input type="text" name="bm"></td></tr>
    <br><br>

    <tr class="input"><td class="label"><label for="is_key">Is there a key?</label></td>
    <td><input type="checkbox" class="check" name="is_key"></td></tr>
    <br><br>

    <tr class="input"><td class="label"><label for="id_number">Key ID</label></td>
    <td><input type="number" name="id_number"></td></tr>
    <br><br>

    <tr class="input"><td class="label"><label for="key_provider">Key Provider</label></td>
    <td><input type="text" name="key_provider"></td></tr>
    <br><br>

    <tr class="input"><td class="label"><label for="large">Key Large?</label></td>
    <td><input type="checkbox" class="check" name="large"></td></tr>
    <br><br>

    <tr class="input"><td class="label"><label for="fip">FIP?</label></td>
    <td><input type="checkbox" class="check" name="fip"></td></tr>
    <br><br>

    <tr class="input"><td class="label"><label for="pump">Pump?</label></td>
    <td><input type="checkbox" class="check" name="pump"></td></tr>
    <br><br>

    <tr class="input"><td><input type="submit" value="Submit" name="submit"></td></tr>
</form>
</table>

<table class="keys">

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

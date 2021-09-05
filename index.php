<!DOCTYPE html>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    #print_r($_POST['user']);


    if ($_POST['login'] == "Login") {
        #print_r("Login started");

        $pdo = new PDO('sqlite:keys.db');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $inputUser = "same";
        $userQ = $pdo->query("SELECT * from people WHERE account IS '". $_POST['user'] . "'");
        #print_r("SELECT * from users WHERE unique IS " . $inputUser);

        $users = $userQ->fetch(PDO::FETCH_ASSOC);
        #print_r("fetch done");
        print_r($users);

        if ($users) {
            if ($users['password'] == $_POST['pass']) {
                print_r("Login Successful");
                $cookie_name = "sessionID";
                $cookie_value = $users['id'];
                #setcookie($cookie_name, $cookie_value, , '/'); // 86400 = 1 day
                setcookie($cookie_name, $cookie_value, [
                    'expires' => time() + 86400,
                    'path' => '/',
                    'domain' => 'dakeys.net',
                    'secure' => true,
                    'httponly' => false,
                    'samesite' => 'None',
                ]);
                 echo "<script> setTimeout(function() {window.location.href = 'monthly.php'}, 500)</script>";
            }
        } else {
            print_r("Incorrect Username");
        }
    }




?>


<html>
<head>
    <title>Login</title>

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

        form {
            text-align: center;
            font-size: 45px;
        }
        input {
            font-size: 45px;
        }
    </style>

</head>

<body>
<h1>Login</h1>
<form method="post" action="index.php">
    <input type="text" name="user" placeholder="Username"><br><br>
    <input type="password" name="pass" placeholder="Password"><br><br>
    <input type="submit" name="login" value="Login">

</form>


</body>




</html>


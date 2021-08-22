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
        <form method="post" action="home.php">
            <input type="text" name="user" placeholder="Username"><br><br>
            <input type="password" name="pass" placeholder="Password"><br><br>
            <input type="submit" name="login" value="Login">

        </form>


    </body>




</html>


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    print_r($_POST['user']);


    if ($_POST['login'] == "Login") {
        print_r("Login started");

        $pdo = new PDO('sqlite:users.db');
        $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $inputUser = "sam";
        $userQ = $pdo->query("SELECT * from users WHERE username IS '". $inputUser . "'");
        print_r("SELECT * from users WHERE username IS '" . $inputUser . "'");

        $users = $userQ->fetchAll(PDO::FETCH_ASSOC);
        print_r("fetch done");
        print_r($users);

        if ($users) {
            if ($users['pass'] == $_POST['pass']) {
                print_r("Login Successful");
            } else {
                print_r("Login Failed");
            }
        } else {
            print_r("Fetch was empty");
        }
    } else {
        die("Ass");
    }




?>

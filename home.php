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
        </style>

    </head>

    <body>
        <h1>Login</h1>
        <form method="post" action="home.php">
            <input type="text" name="user">
            <input type="password" name="pass">
            <input type="submit" value="Login">

        </form>


    </body>




</html>


<?php

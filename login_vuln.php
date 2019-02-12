<?php
    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $error_msg = "[+] username or password is empty.";
            echo $error_msg;
        } else {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $pdo = new PDO("mysql:host=localhost; dbname=sqli_test; charset=utf8", "root", "****");
            $stmt = "SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'";
            $stmh = $pdo->prepare($stmt);
            $stmh->execute();

            $count = $stmh->rowCount();
            if ($count != 0) {
                echo "[+] Login successful.";

                echo "<table border=\"1\">";
                echo "<tr>";
                echo "<th>Favorite Food</th>";
                echo "</tr>";

                $result = $stmh->fetchAll();
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>".$row[3]."</td>";
                    echo "</tr>";
                }

                echo "</table>";
            } else {
                $error_msg = "[+] Login failed.";
                echo $error_msg;
            }
        }
    }
?>

<!doctype html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <h1>login</h1>
        <form id="login_form" name="login_form" action="" method="POST">
            <span>username</span>
            <input type="text" id="username" name="username" placeholder="username" value="">
            <br/>
            <span>password</span>
            <input type="password" id="password" name="password" placeholder="password" value="">
            <br/>
            <input type="submit" id="login" name="login" value="login">
        </form>
    </body>
</html>

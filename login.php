<?php
    if (isset($_POST["login"])) {
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            $error_msg = "[+] username or password is empty.";
            echo $error_msg;
        } else {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $opt = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                         PDO::MYSQL_ATTR_MULTI_STATEMENTS => false,
                         PDO::ATTR_EMULATE_PREPARES => false); // PDO用のオプション
            $pdo = new PDO("mysql:host=localhost; dbname=sqli_test; charset=utf8", "root", "****", $opt);
            $stmt = "SELECT * FROM users WHERE username = ? AND password = ?"; // プレースホルダの使用
            $stmh = $pdo->prepare($stmt);
            $stmh->bindValue(1, $username, PDO::PARAM_STR); // ユーザ名のバインド
            $stmh->bindValue(2, $password, PDO::PARAM_STR); // パスワードのバインド
            $stmh->execute();

            $count = $stmh->rowCount();
            if ($count != 0) {
                echo "[+] Login successful.";
                echo "<br/>";

                echo "<table border=\"1\">";
                echo "<tr>";
                echo "<th>Favorite Food</th>";
                echo "</tr>";

                $result = $stmh->fetchAll();
                foreach ($result as $row) {
                    echo "<tr>";
                    echo "<td>".htmlspecialchars($row[3], ENT_QUOTES, "UTF-8")."</td>"; // 出力する文字のエスケープ
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

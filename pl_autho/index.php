<?php

session_start();
if (isset($_SESSION['login'])) {
    header("Location: http://localhost/diplom/pl_main/");
}

if (isset($_POST['enter'])) {
    echo "<h2>Войти</h2>";
}
if (isset($_POST['forgot'])) {
    echo "<h3>Забыл пароль</h3>";
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Вход в платформу</title>
</head>
<body>
<form action="check.php" method="post">
    <div>
        <div>
            <label>Логин:</label>
            <input type="text" name="login" id="">
        </div>
        <div>
            <label>Пароль:</label>
            <input type="password" name="password" id="">
        </div>
        <div>
            <input type="submit" value="Войти" name="enter">
            <input type="submit" value="Восстановление пароля" name="forgot">
        </div>
    </div>
</form>
</body>
</html>
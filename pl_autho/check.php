<?php
session_start();

if (!isset($_POST['enter']) && !isset($_POST['forgot'])) {
    exit();
}

if (isset($_POST['forgot'])) {
    echo "Происходит перенаправление на страницу восстановления пароля";
}
if (isset($_POST['enter'])) {
    /*Обращаемся к полученным данным*/
    $login = $_POST['login'];
    $password = $_POST['password'];
    /*Производим запрос на проверку пользователя*/
    include_once '../_scripts/connection.php';
    $link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
    $textOfQuery = "SELECT acc_firstname, acc_lastname, acc_id, acc_password FROM account WHERE acc_login = '$login'";
    $query = mysqli_query($link, $textOfQuery);
    $result = mysqli_fetch_assoc($query);
    /*Если такой пользователь есть, и пароль введен правильно*/
    if (password_verify($password, $result['acc_password'])) {
        $_SESSION['firstName'] = $result['acc_firstname'];
        $_SESSION['lastName'] = $result['acc_lastname'];
        $_SESSION['login'] = $login;
        /*Ищем в базе данных тип найденной учетной записи*/
        $resultId = $result['acc_id'];
        $textOfQuery = "SELECT adm_id FROM administrator WHERE adm_acc_id = $resultId";
        $query = mysqli_query($link, $textOfQuery);
        $result = mysqli_fetch_assoc($query);
        if ($result) {
            $_SESSION['administrator'] = $result['adm_id'];
        } else {
            $textOfQuery = "SELECT stu_id FROM student WHERE stu_acc_id = $resultId";
            $query = mysqli_query($link, $textOfQuery);
            $result = mysqli_fetch_assoc($query);
            if ($result) {
                $_SESSION['student'] = $result['stu_id'];
            } else {
                $textOfQuery = "SELECT tut_id FROM tutor WHERE tut_acc_id = $resultId";
                $query = mysqli_query($link, $textOfQuery);
                $result = mysqli_fetch_assoc($query);
                if ($result) {
                    $_SESSION['tutor'] = $result['tut_id'];
                } else {
                    $_SESSION['guest'] = true;
                }
            }
        }
        header("Location: http://localhost/diplom/pl_main");
    } else {
        print ("Неверные данные авторизации, повторите попытку");
    }
    mysqli_close($link);
}
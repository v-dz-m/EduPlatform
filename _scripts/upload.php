<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: http://localhost/diplom/pl_autho/");
} else if (isset($_SESSION['student'])) {
    header("Location: http://localhost/diplom/pl_main/");
}

if (isset($_FILES['newFile'])) {
    $errors = array();
    $file_name = $_FILES['newFile']['name'];
    $file_name_bd = $file_name;
    $file_name = iconv('UTF-8', 'WINDOWS-1251', $file_name);
    $file_size = $_FILES['newFile']['size'];
    $file_tmp = $_FILES['newFile']['tmp_name'];
    $file_type = $_FILES['newFile']['type'];
    if (empty($errors)) {
        $address =
            move_uploaded_file($file_tmp, "C:\wamp64\www\diplom\_docs\\" . $file_name);
        include_once "connection.php";
        $link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
        $name = $_POST['bookName'];
        $desc = $_POST['bookDesc'];
        $author = $_POST['bookAuthor'];
        $year = $_POST['bookYear'];
        $textOfQuery = "INSERT INTO material VALUES (NULL, '$name', '$desc', '$author', $year, UNIX_TIMESTAMP(), 
'$file_name_bd');";
        $query = mysqli_query($link, $textOfQuery);
        mysqli_close($link);
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../_css/mainstyle.css">
</head>
<body>
<?php include_once "header.php"; ?>
<form action="" method="post" enctype="multipart/form-data" id="bookForm">
    <div class="formRow">
        <h3>Загрузить материал в библиотеку</h3>
    </div>
    <div class="formRow">
        <label>Название книги:</label><input type="text" name="bookName" required>
    </div>
    <div class="formRow">
        <label>Описание:</label><textarea name="bookDesc" maxlength="256"
                                          placeholder="Не более 256 символов" rows="4" cols="22"></textarea>
    </div>
    <div class="formRow">
        <label>Автор книги:</label><input type="text" name="bookAuthor" required>
    </div>
    <div class="formRow">
        <label>Год публикации:</label><input type="text" name="bookYear" required>
    </div>
    <div class="formRow">
        <input type="file" name="newFile">
        <input type="submit" value="Загрузить">
    </div>
</form>
<?php include_once "footer.php"; ?>
<script src="../_js/jquery-3.3.1.min.js"></script>
<script src="../_js/linkToMainPage.js"></script>
</body>
</html>


<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: http://localhost/diplom/pl_autho/");
} else if (isset($_SESSION['administrator'])) {
    header("Location: http://localhost/diplom/pl_main/");
}

include_once "../../_scripts/connection.php";
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
$userLogin = $_SESSION['login'];

if (isset($_POST['edit'])) {
    $sex = $_POST['sex'];
    $region = $_POST['region'];
    $firstName = $_POST['first-name'];
    $lastName = $_POST['last-name'];
    $email = $_POST['email'];
    $textOfQueryForUpdate = "UPDATE account SET acc_sex_id = $sex, acc_reg_id = $region, acc_firstname = '$firstName', acc_lastname = 
'$lastName', acc_email = '$email' WHERE acc_login = '$userLogin';";
    $queryForUpdate = mysqli_query($link, $textOfQueryForUpdate);
    if ($queryForUpdate) {
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        echo "<script>alert('Запись успешно изменена');</script>";
    }
}

$textOfQuery = "SELECT acc_sex_id, acc_reg_id, acc_firstname, acc_lastname, acc_email FROM account WHERE acc_login = '$userLogin';";
$query = mysqli_query($link, $textOfQuery);
$result = mysqli_fetch_assoc($query);
if ($result) {
    $oldSexId = $result['acc_sex_id'];
    $oldRegionId = $result['acc_reg_id'];
    $oldFirstName = $result['acc_firstname'];
    $oldLastName = $result['acc_lastname'];
    $oldEmail = $result['acc_email'];
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../../_css/mainstyle.css">
</head>
<body>
<?php include_once "../../_scripts/header.php" ?>
<form action="index.php" method="post">
    <div class="formRow">
        <label>Логин:</label>
        <p><?php echo $userLogin ?></p>
    </div>
    <div class="formRow">
        <label>Пол:</label>
        <select name="sex" id="">
            <?php
            $textOfQueryForSex = "SELECT sex_id, sex_rusname FROM sex;";
            $queryForSex = mysqli_query($link, $textOfQueryForSex);
            $numberForSex = mysqli_num_rows($queryForSex);
            for ($i = 0; $i < $numberForSex; $i++) {
                $rowEntry = mysqli_fetch_row($queryForSex);
                $rowId = $rowEntry[0];
                $rowName = $rowEntry[1];
                ?>
                <option <?php if ($rowId == $oldSexId) {
                    echo "selected";
                } ?> value="<?php echo $rowId ?>"><?php echo $rowName ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="formRow">
        <label>Страна:</label>
        <select name="region" id="">
            <?php
            $textOfQueryForRegion = "SELECT reg_id, reg_rusname FROM region;";
            $queryForRegion = mysqli_query($link, $textOfQueryForRegion);
            $numberForRegion = mysqli_num_rows($queryForRegion);
            for ($i = 0; $i < $numberForRegion; $i++) {
                $rowEntry = mysqli_fetch_row($queryForRegion);
                $rowId = $rowEntry[0];
                $rowName = $rowEntry[1];
                ?>
                <option <?php if ($rowId == $oldRegionId) {
                    echo "selected";
                } ?> value="<?php echo $rowId ?>"><?php echo $rowName ?></option>
                <?php
            }
            ?>
        </select>
    </div>
    <div class="formRow">
        <label>Имя:</label>
        <input type="text" name="first-name" id="" value="<?php echo $oldFirstName ?>">
    </div>
    <div class="formRow">
        <label>Фамилия:</label>
        <input type="text" name="last-name" id="" value="<?php echo $oldLastName ?>">
    </div>
    <div class="formRow">
        <label>Email:</label>
        <input type="text" name="email" id="" value="<?php echo $oldEmail ?>">
    </div>
    <div class="formRow">
        <input type="submit" name="edit" value="Сохранить">
        <input type="reset" value="Восстановить">
    </div>
</form>
<?php include_once "../../_scripts/footer.php" ?>
<script src="../../_js/jquery-3.3.1.min.js"></script>
<script src="../../_js/linkToMainPage.js"></script>
</body>
</html>

<?php
mysqli_close($link);
?>

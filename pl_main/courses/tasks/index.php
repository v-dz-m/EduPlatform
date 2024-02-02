<?php
session_start();
if (!isset($_SESSION)) {
    header("Location: http://localhost/diplom/autho/");
} else if (!isset($_POST['indexTasks'])) {
    header("Location: http://localhost/diplom/pl_main/");
}
$index = $_POST['indexTasks'];

include_once "../../../_scripts/connection.php";
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
?>

    <!doctype html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../../../_css/mainstyle.css">
        <link rel="stylesheet" href="../../../_css/chatstyle.css">
        <title>Задания</title>
    </head>
    <body>
    <?php include_once "../../../_scripts/header.php"; ?>
    <div id="tasks-wrapper">
        <div id="tasks-box">
            <?php
            if (isset($_SESSION['student'])) {
                $userId = $_SESSION['student'];
                $textOfQuery = "SELECT task.* FROM task, participant, student, team, course WHERE (par_id = tas_par_id) AND (tea_id = par_tea_id) AND (cou_id = tea_cou_id) AND (cou_id = $index) AND (stu_id = par_stu_id) AND (stu_id = $userId)";
            } else {
                $textOfQuery = "SELECT task.*, acc_firstname, acc_lastname FROM task, participant, team, course, student, account WHERE (par_id = tas_par_id) AND (tea_id = par_tea_id) AND (cou_id = tea_cou_id) AND (cou_id = $index) AND (stu_id = par_stu_id) AND (acc_id = stu_acc_id)";
            }
            printf ('<script>alert("%s")</script>', $textOfQuery, $index);
            $query = mysqli_query($link, $textOfQuery);
            if (mysqli_num_rows($query) > 0) {
                $row = mysqli_fetch_assoc($query);
                do {
                    if (isset($_SESSION['student'])) {
                        printf('<table id="%s"><tr><td>Учащийся:</td><td>%s %s</td></tr><tr><td>Файл условия:</td><td><a href="%s">Ссылка</a></td></tr><tr><td>Файл решения:</td><td><a href="%s">Ссылка</a></td></tr></table>', $row['tas_id'], $_SESSION['firstName'], $_SESSION['lastName'], $row['tas_input'], $row['tas_output']);
                    } else {
                        printf('<table id="%s"><tr><td>Учащийся:</td><td>%s %s</td></tr><tr><td>Файл условия:</td><td><a href="%s">Ссылка</a></td></tr><tr><td>Файл решения:</td><td><a href="%s">Ссылка</a></td></tr></table>', $row['tas_id'], $row['acc_firstname'], $row['acc_lastname'], $row['tas_input'], $row['tas_output']);
                        //printf('<div class="tasks" id="%s"></div>', $row['tas_id']);
                    }
                } while ($row = mysqli_fetch_assoc($query));
            }
            ?>
        </div>
        <div id="tasks-participants">

        </div>
    </div>
    <?php include_once "../../../_scripts/footer.php"; ?>
    <script src="../../../_js/jquery-3.3.1.min.js"></script>
    <script src="../../../_js/linkToMainPage.js"></script>
    </body>
    </html>

<?php
mysqli_close($link);

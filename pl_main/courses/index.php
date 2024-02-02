<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: http://localhost/diplom/pl_autho/");
}
include_once "../../_scripts/connection.php";
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Курсы</title>
        <link rel="stylesheet" href="../../_css/mainstyle.css">
        <link rel="stylesheet" href="../../_css/coursestyle.css">
    </head>
    <body>
    <?php include_once "../../_scripts/header.php"; ?>
    <div id="course-wrapper">
        <div id="course-box">
            <div>
                <h3>Блок 1</h3>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam, assumenda beatae, dolor eius eos illo
                impedit laborum perspiciatis quam quas quidem quisquam ratione recusandae, repellat tempora ullam ut
                veritatis voluptatum.
            </div>
            <div>
                <h3>Блок 2</h3>
                Accusantium dolor ea eveniet exercitationem illo impedit iusto maiores nulla, quae quam quasi quia quo
                repellendus totam voluptas voluptates voluptatibus. Aliquid consequatur fuga ipsam officia provident qui
                reprehenderit sequi sit.
            </div>
            <div>
                <h3>Блок 3</h3>
                Ad aliquam aspernatur assumenda blanditiis corporis culpa dolor esse facilis incidunt ipsa itaque libero
                minus molestias necessitatibus nisi nostrum pariatur, perspiciatis qui quia quod rerum sunt suscipit
                tempora tempore voluptatum.
            </div>
            <div>
                <form method="post" action="chat/index.php" class="forms">
                    <input type="hidden" name="index">
                    <button type="submit">Перейти к чату</button>
                </form>
            </div>
            <div>
                <form method="post" action="tasks/index.php" class="forms">
                    <input type="hidden" name="indexTasks">
                    <button type="submit">Перейти к заданиям</button>
                </form>
            </div>
        </div>
        <div id="course-list">
            <h3>Мои курсы</h3>
            <?php
            if (isset($_SESSION['tutor'])) {
                $tutorId = $_SESSION['tutor'];
                $textOfQuery = "SELECT cou_id, cou_name FROM course WHERE cou_tut_id = $tutorId";
                $query = mysqli_query($link, $textOfQuery);
                if (mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_assoc($query);
                    do {
                        printf('<div class="course-list-elements" id="%s"><p>%s</p></div>', $row['cou_id'], $row['cou_name']);
                    } while ($row = mysqli_fetch_assoc($query));
                } else {
                    print ('<p class="no-course">У вас нет ни одного курса.</p>');
                }
            } else if (isset($_SESSION['student'])) {
                $studentId = $_SESSION['student'];
                $textOfQuery = "SELECT DISTINCT cou_id, cou_name FROM course, team, participant, student WHERE (cou_id = tea_cou_id) AND (tea_id = par_tea_id) AND (par_stu_id = $studentId)";
                $query = mysqli_query($link, $textOfQuery);
                if (mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_assoc($query);
                    do {
                        printf('<div class="course-list-elements" id="%s"><p>%s</p></div>', $row['cou_id'], $row['cou_name']);
                    } while ($row = mysqli_fetch_assoc($query));
                } else {
                    print ('<p class="no-course">У вас нет ни одного курса.</p>');
                }
            }
            ?>
        </div>
    </div>
    <?php include_once "../../_scripts/footer.php"; ?>
    <script src="../../_js/jquery-3.3.1.min.js"></script>
    <script src="../../_js/linkToMainPage.js"></script>
    <script>
        $(document).ready(function () {
            $('.course-list-elements').on('click', function () {
                if (!$(this).hasClass('selected')) {
                    $('.course-list-elements').removeClass('selected');
                    $(this).addClass('selected');
                    $('#course-box').find('input[name="index"]').val($(this).attr('id'));
                    $('#course-box').find('input[name="indexTasks"]').val($(this).attr('id'));
                }
            });
            $('.forms').on('submit', function () {
               if ($('.course-list-elements.selected').length == 0) {
                   alert("Пожалуйста, выберите курс.");
                   return false;
               }
            });
        })
    </script>
    </body>
    </html>

<?php
mysqli_close($link);
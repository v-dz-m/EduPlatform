<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: http://localhost/diplom/pl_autho/");
} else if (!isset($_POST['index'])) {
    header("Location: http://localhost/diplom/pl_main/");
}
$index = $_POST['index'];

include_once "../../../_scripts/connection.php";
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Сетевой чат</title>
        <link rel="stylesheet" href="../../../_css/mainstyle.css">
        <link rel="stylesheet" href="../../../_css/chatstyle.css">
    </head>
    <body>
    <?php include_once "../../../_scripts/header.php"; ?>
    <div id="chat-wrapper">
        <div id="chat-box">
            <div id="chat-messages">
                <?php
                if (isset($_SESSION['student'])) {
                    $userId = $_SESSION['student'];
                    $textOfQuery = "SELECT mes_id, mes_direction, mes_content, mes_time FROM message, participant, student, team, course WHERE (par_id = mes_par_id) AND (tea_id = par_tea_id) AND (cou_id = tea_cou_id) AND (cou_id = $index) AND (stu_id = par_stu_id) AND (stu_id = $userId) ORDER BY mes_id DESC";
                    $query = mysqli_query($link, $textOfQuery);
                    if (mysqli_num_rows($query) > 0) {
                        $row = mysqli_fetch_assoc($query);
                        do {
                            if ($row['mes_direction'] == 0) {
                                printf('<div class="messages left-messages" id="%s"><p>%s</p><p>%s</p></div>',
                                    $row['mes_id'], $row['mes_content'], gmdate('H:i d.m.y', $row['mes_time'] + 10800));
                            } else {
                                printf('<div class="messages right-messages" id="%s"><p>[Вы] %s</p><p>%s</p></div>',
                                    $row['mes_id'], $row['mes_content'], gmdate('H:i d.m.y', $row['mes_time'] + 10800));
                            }

                        } while ($row = mysqli_fetch_assoc($query));
                    } else {
                        print ('<p class="no-message">Сообщений не обнаружено</p>');
                    }
                } else {
                    print ('<p class="no-message">Выберите собеседника</p>');
                }
                ?>
            </div>
            <div id="chat-buttons">
                <textarea rows="5" maxlength="256" wrap="soft"
                          placeholder="Введите сюда свое сообщение (не более 256 символов)"></textarea>
                <button>Отправить сообщение</button>
            </div>
        </div>
        <div id="chat-participants">
            <h3>Выберите собеседника</h3>
            <?php
            if (isset($_SESSION['tutor'])) {
                $textOfQuery = "SELECT acc_firstname, acc_lastname, stu_id FROM team, participant, student, account WHERE (par_tea_id = tea_id) AND (par_stu_id = stu_id) AND (stu_acc_id = acc_id) AND (tea_cou_id = $index)";
                $query = mysqli_query($link, $textOfQuery);
                if (mysqli_num_rows($query) > 0) {
                    $row = mysqli_fetch_assoc($query);
                    do {
                        printf('<div class="participants" id="%s">%s %s</div>', $row['stu_id'], $row['acc_firstname'], $row['acc_lastname']);
                    } while ($row = mysqli_fetch_assoc($query));
                } else {
                    print ('<p class="no-participant">Пользователей не обнаружено</p>');
                }
            }
            ?>
        </div>
    </div>
    <?php include_once "../../../_scripts/footer.php"; ?>
    <script src="../../../_js/jquery-3.3.1.min.js"></script>
    <script src="../../../_js/linkToMainPage.js"></script>
    <script>
        $(document).ready(function () {
            $('#chat-buttons').on('click', 'button', function () {
                var textMessage = $("#chat-buttons").find('textarea').val();
                if (textMessage == "") {
                    alert("Текст не найден");
                } else {
                    var userId = <?php if (isset($_SESSION['student'])) {
                            print ($_SESSION['student']);
                        } else {
                            print ("$('.participants.selected').attr('id')");
                        }
                        ?>;
                    var index = <?php print ($index) ?>;
                    var direction = <?php if (isset($_SESSION['student'])) {
                            print (1);
                        } else {
                            print (0);
                        }
                        ?>;
                    $.ajax({
                        url: "sendMessage.php",
                        type: "POST",
                        data: {text: textMessage, index: index, userId: userId, direction: direction},
                        success: function () {
                            $("#chat-buttons").find('textarea').val("");
                        }
                    });
                }
            });

            $(".participants").on('click', function () {
                if (!$(this).hasClass('selected')) {
                    $('.participants').removeClass('selected');
                    $(this).addClass('selected');
                    $('.messages').remove();
                }
            });

            window.setInterval(function () {
                var id = $('.messages:first').attr('id');
                var userId = <?php if (isset($_SESSION['student'])) {
                        print ($_SESSION['student']);
                    } else {
                        print ("$('.participants.selected').attr('id')");
                    }
                    ?>;
                var index = <?php print ($index) ?>;
                if (!isNaN(userId) && isNaN(id)) {
                    id = 0;
                    $.ajax({
                        url: 'showMessages.php',
                        type: 'POST',
                        data: {id: id, userId: userId, index: index},
                        success: function (data) {
                            if (data != 1) {
                                $('.no-message').remove();
                                $('#chat-messages').prepend(data);
                            } else {
                                if ($('.no-message').length == 0) {
                                    $('#chat-messages').prepend("<div class='no-message'>Сообщений не найдено</div>");
                                }
                            }
                        }
                    });
                } else if (!isNaN(id)) {
                    $.ajax({
                        url: 'showMessages.php',
                        type: 'POST',
                        data: {id: id, userId: userId, index: index},
                        success: function (data) {
                            if (data != 1) {
                                $('.no-message').remove();
                                $('#chat-messages').prepend(data);
                            }
                        }
                    });
                }
            }, 1000);
        });
    </script>
    </body>
    </html>
<?php
mysqli_close($link);
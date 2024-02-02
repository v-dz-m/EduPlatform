<?php
include_once "../../../_scripts/connection.php";
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);

$id = $_POST['id'];
$index = $_POST['index'];
$userId = $_POST['userId'];

$textOfQuery = "SELECT mes_id, mes_direction, mes_content, mes_time FROM message, participant, student, team, course WHERE (mes_id > $id) AND (par_id = mes_par_id) AND (tea_id = par_tea_id) AND (cou_id = tea_cou_id) AND (cou_id = $index) AND (stu_id = par_stu_id) AND (stu_id = $userId) ORDER BY mes_id DESC";
$query = mysqli_query($link, $textOfQuery);

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    do {
        if ($row['mes_direction'] == 0) {
            printf('<div class="messages left-messages" id="%s"><p>[Вы] %s</p><p>%s</p></div>',
                $row['mes_id'], $row['mes_content'], gmdate('H:i d.m.y', $row['mes_time'] + 10800));
        } else {
            printf('<div class="messages right-messages" id="%s"><p>%s</p><p>%s</p></div>',
                $row['mes_id'], $row['mes_content'], gmdate('H:i d.m.y', $row['mes_time'] + 10800));
        }

    } while ($row = mysqli_fetch_assoc($query));

} else {
    echo 1;
}

mysqli_close($link);
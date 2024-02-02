<?php
include_once "../../../_scripts/connection.php";
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);

$text = $_POST['text'];
$index = $_POST['index'];
$userId = $_POST['userId'];
$direction = $_POST['direction'];

$textOfQuery = "SELECT par_id FROM course, team, participant WHERE (par_tea_id = tea_id) AND (tea_cou_id = cou_id) AND (cou_id = $index) AND (par_stu_id = $userId)";
$query = mysqli_query($link, $textOfQuery);
$result = mysqli_fetch_assoc($query);
if ($result['par_id']) {
    $id = $result['par_id'];
    $textOfQuery = "INSERT INTO message VALUES (NULL, $id, $direction, '$text', UNIX_TIMESTAMP());";
    $query = mysqli_query($link, $textOfQuery);
}


mysqli_close($link);
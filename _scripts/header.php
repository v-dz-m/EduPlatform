<?php
$userName = $_SESSION['firstName'];
$userSurname = $_SESSION['lastName'];
?>

<header>
    <div class="header-info">
        <h2><?php print "$userName $userSurname"?></h2>
        <a href="http://localhost/diplom/pl_autho/exit.php"><button>Покинуть систему</button></a>
    </div>
</header>
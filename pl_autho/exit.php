<?php
session_start();
session_destroy();
header("Location: http://localhost/diplom/index.php");
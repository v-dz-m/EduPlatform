<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../_css/mainstyle.css">
</head>
<body class="main-page">

</body>
</html>
<script src="../_js/jquery-3.3.1.min.js"></script>
<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: http://localhost/diplom/pl_autho/");
}
include_once "../_scripts/connection.php";

include_once "../_scripts/header.php";

/*Если пользователь - администратор*/
if (isset($_SESSION['administrator'])) {
    echo "<div class='panel administrator'>
    <h3>АДМИНИСТРАТОР</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur illo similique ut. At fuga natus nihil recusandae voluptatum! Aspernatur consequatur cupiditate distinctio et facilis in officiis placeat sed vero voluptatibus?</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut corporis dignissimos earum ipsa laborum quibusdam quod temporibus vel! Accusantium corporis culpa distinctio eveniet facere, molestias porro provident reprehenderit vero voluptatibus?</p>
    <p>Accusamus accusantium commodi delectus dicta dolore dolores dolorum enim facilis fugit hic illo impedit maxime mollitia neque nostrum odio officia officiis, perferendis possimus praesentium quidem ratione, sint unde, veniam voluptatem!</p>
     </div>";
    //Пункт "Менеджер управления базой данных"
    echo "<div class='panel student'>
    <a href=''><h3>Менеджер управления базой данных</h3></a>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aut eaque esse excepturi fugit harum maiores nesciunt non omnis perspiciatis quaerat qui quidem, quos recusandae repellendus similique veniam voluptatem voluptatibus.</p>
    </div>";
}
/*Если пользователь - учащийся*/
if (isset($_SESSION['student'])) {
    echo "<div class='panel student'>
    <h3>УЧАЩИЙСЯ</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid aspernatur commodi consequatur culpa deleniti distinctio, dolore enim facilis harum illum iste laborum minus nulla perspiciatis qui, quos sapiente sint vel.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Beatae consequuntur corporis cumque dolorem, dolorum, error esse fugit harum id itaque molestias neque possimus quae quasi quisquam reiciendis unde vitae, voluptatum.</p>
    <p>A alias aliquam aliquid aperiam corporis culpa cum cumque cupiditate delectus deserunt, eum ex facere fugit ipsam laborum libero minima molestias mollitia nesciunt, officiis quam qui quisquam quod, repellendus similique!</p>
    </div>";
}
/*Если пользователь - преподаватель*/
if (isset($_SESSION['tutor'])) {
    //Блок информации для преподавателя
    echo "<div class='panel tutor'>
    <h3>ПРЕПОДАВАТЕЛЬ</h3>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur dicta dignissimos, eaque est ipsum magnam necessitatibus neque nihil possimus tempora, veniam veritatis voluptatum. Assumenda, at commodi cupiditate officia quo totam.</p>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, dignissimos dolore, dolores explicabo fuga id in ipsum iure labore laboriosam magnam obcaecati optio porro, provident quaerat quia reiciendis voluptates voluptatum.</p>
    <p>Delectus deleniti deserunt dolorem ea impedit, in iste itaque iusto magni maiores mollitia nulla, officia omnis pariatur quia quibusdam quisquam reiciendis repellendus, rerum sapiente suscipit totam unde veniam voluptatem voluptatum.</p>
    </div>";
    //Пункт "Менеджер создания нового курса"
    echo "<div class='panel linkToCreateCourse'>
    <a href=''><h3>Менеджер создания нового курса</h3></a>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus aut eaque esse excepturi fugit harum maiores nesciunt non omnis perspiciatis quaerat qui quidem, quos recusandae repellendus similique veniam voluptatem voluptatibus.</p>
    </div>";
}
/*Если пользователь не учащийся*/
if (!isset($_SESSION['student'])) {
    //Пункт "Менеджер добавления материалов в библиотеку"
    echo "<div class='panel linkToAddMaterial'>
    <a href='http://localhost/diplom/_scripts/upload.php'><h3>Менеджер добавления материалов в библиотеку</h3></a>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci amet cupiditate debitis eligendi error est id in maxime molestiae nam qui quod repellat repellendus rerum, unde vitae voluptas. Deserunt, exercitationem?</p>
    </div>";
}
/*Если пользователь не администратор*/
if (!isset($_SESSION['administrator'])) {
    //Пункт "Редактор данных учетной записи"
    echo "<div class='panel administrator'>
    <a href='http://localhost/diplom/pl_main/settings/'><h3>Редактор данных учетной записи</h3></a>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci animi eligendi error ex id itaque nihil quas sapiente similique soluta. Consequuntur cum debitis eius id magni officia quae reiciendis, voluptas?</p>
    </div>";
    //Пункт "Курсы"
    echo "<div class='panel linkToSettings'>
    <a href='http://localhost/diplom/pl_main/courses/'><h3>Курсы</h3></a>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci animi eligendi error ex id itaque nihil quas sapiente similique soluta. Consequuntur cum debitis eius id magni officia quae reiciendis, voluptas?</p>
    </div>";
}

echo "<div class='panel linkToLibrary'>
    <a href='http://localhost/diplom/pl_main/library/'><h3>Библиотека материалов</h3></a>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid amet consectetur, cupiditate distinctio dolor eaque eos eveniet illo impedit ipsum laboriosam minus odio perferendis, placeat praesentium quod ratione repudiandae rerum!</p>
    </div>";

include_once "../_scripts/footer.php";


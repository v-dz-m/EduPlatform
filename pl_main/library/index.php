<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: http://localhost/diplom/pl_autho/");
}

include_once "../../_scripts/connection.php";
$link = mysqli_connect($db_host, $db_user, $db_password, $db_name);
//Запрос на получение информации о материалах
$textOfQuery = "SELECT mat_name, mat_description, mat_author, mat_year, mat_publishing, mat_source FROM material ORDER BY 
mat_publishing DESC";
$query = mysqli_query($link, $textOfQuery);
$number = mysqli_num_rows($query);
//Запрос на получение информации об авторах материалов
$textOfQueryForAuthor = "SELECT DISTINCT mat_author FROM material";
$queryForAuthor = mysqli_query($link, $textOfQueryForAuthor);
$numberForAuthor = mysqli_num_rows($queryForAuthor);
//Запрос на получение информации об годах издания материалов
$textOfQueryForYear = "SELECT DISTINCT mat_year FROM material";
$queryForYear = mysqli_query($link, $textOfQueryForYear);
$numberForYear = mysqli_num_rows($queryForYear);
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Библиотека материалов</title>
        <link rel="stylesheet" href="../../_css/mainstyle.css">
    </head>
    <body>
    <?php include_once "../../_scripts/header.php"; ?>
    <div id="container-find">
        <div id="search">

        </div>
        <div id="filter">
            <div class="filterParameter">
                <label for="filterAuthor">Автор книги:</label>
                <select name="" id="filterAuthor">
                    <option value="0">Любой</option>
                    <?php
                    for ($i = 0; $i < $numberForAuthor; $i++) {
                        $rowSpecEntry = mysqli_fetch_row($queryForAuthor);
                        $rowSpecAuthor = $rowSpecEntry[0];
                        ?>
                        <option value="<?php echo "$rowSpecAuthor" ?>"> <?php echo "$rowSpecAuthor" ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <div class="filterParameter">
                <label for="filterYear">Год издания:</label>
                <select name="" id="filterYear">
                    <option value="0">Любой</option>
                    <?php
                    for ($i = 0; $i < $numberForYear; $i++) {
                        $rowSpecEntry = mysqli_fetch_row($queryForYear);
                        $rowSpecYear = $rowSpecEntry[0];
                        ?>
                        <option value="<?php echo "$rowSpecYear" ?>"> <?php echo "$rowSpecYear" ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div id="container-catalog">
        <div id="catalog">
            <?php
            for ($i = 0; $i < $number; $i++) {
                $rowEntry = mysqli_fetch_row($query);
                $rowName = $rowEntry[0];
                $rowDescription = $rowEntry[1];
                $rowAuthor = $rowEntry[2];
                $rowYear = $rowEntry[3];
                $rowPublishing = $rowEntry[4];
                $rowSource = $rowEntry[5];
                ?>
                <div class="book" data-author="<?php echo "$rowAuthor" ?>" data-year="<?php echo "$rowYear" ?>">
                    <div class="book-title">
                        <h3><?php echo "$rowName - $rowAuthor" ?></h3>
                    </div>
                    <div class="book-details">
                        <table class="book-details-table">
                            <tr>
                                <td>Описание книги:</td>
                                <td><?php echo "$rowDescription" ?></td>
                            </tr>
                            <tr>
                                <td>Год издания:</td>
                                <td><?php echo "$rowYear" ?></td>
                            </tr>
                            <tr>
                                <td>Опубликовано:</td>
                                <td><?php echo gmdate('d.m.y', $rowPublishing + 10800) ?></td>
                            </tr>
                            <tr>
                                <td>Ссылка:</td>
                                <td><a href="<?php echo 'http://localhost/diplom/_docs/' . $rowSource ?>"
                                       target="_blank">перейти</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <?php include_once "../../_scripts/footer.php"; ?>
    <script src="../../_js/jquery-3.3.1.min.js"></script>
    <script src="../../_js/linkToMainPage.js"></script>
    <script src="../../_js/scriptsForLibrary.js"></script>
    <script>
        $(document).ready(function () {
            $('.book:first').find('.book-details').slideDown();
            $('.book-title').on('click', showDetails);
            $('#filter').on('change', 'select', hideBooks);
        });
    </script>
    </body>
    </html>

<?php
mysqli_close($link);

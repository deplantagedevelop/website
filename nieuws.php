<?php

//onchange="document.getElementById('formName').submit()" in de form

include('header.php');
include('lib/connection.php');


$newscategories = $conn->prepare("SELECT * FROM newscategory");
$newscategories->execute();
$newscategory = $newscategories->fetchAll();
$newscategories = NULL;

function test()
{
    global $conn;
    $newsitems = $conn->prepare("SELECT * FROM news");
    $newsitems->execute();
    $newsitem = $newsitems->fetchAll();
    $newsitems = NULL;
    return $newsitem;
}


?>
<section class="content content-news">
    <div class="heading">
        <h1>Nieuws</h1>
    </div>
    <div class="main-news">
        <div class="news-category">
            <form id="main-news" method="POST">
                <?php
                foreach ($newscategory as $category) {
                    $name = $category["name"];
                    $category_id = $category["ID"];
                    echo '<input type="checkbox" name="category[]" value=' . $category_id . '>' . $name . '<br>';
                }
                ?>
                <input type="submit" name="submit"><br>
            </form>
            <?php
            echo '<pre>';
            var_dump($_POST);
            exit;

            ?>
        </div>
        <div class="news-item">
            <?php

            $test = test();
            var_dump($test);
            /*foreach ($test as $item) {

                print($item["title"] . "<br>");
                print($item["description"] . "<br>");
                print("<br>");
            }*/
            ?>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>

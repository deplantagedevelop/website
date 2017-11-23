<?php
//notes:
//onchange="document.getElementById('formName').submit()" in de form


//includes:
include('header.php');
include('lib/connection.php');


//vars:
$descmax = 175;
$newscategories = $conn->prepare("SELECT nc.name, nc.ID, COUNT(n.ID) AS amount FROM newscategory AS nc LEFT JOIN news AS n ON nc.ID=n.categoryID GROUP BY nc.ID");
$newscategories->execute();
$newscategory = $newscategories->fetchAll();
$newscategories = NULL;


//check for submit
if (isset($_GET['categorie'])) {
    $category = $_GET['categorie'];
    $newscategoryquery = ' WHERE nc.ID = "' . $category . '"';
} else {
    $newscategoryquery = '';
    $class = '';
}

//functions:
function shorten($text, $max)
{
    echo '<br>';
    if (strlen($text) <= $max) {
        echo $text;
    } else {
        echo substr($text, 0, $max - 3) . '...';
    }
    echo '<br>(' . strlen($text) . ' meer tekens) ';
}

function news()
{
    global $conn, $descmax, $_GET, $newscategoryquery;
    $newsitems = $conn->prepare("SELECT n.ID, image, title, description FROM news AS n INNER JOIN newscategory AS nc ON n.categoryID = nc.ID" . $newscategoryquery . " ORDER BY n.ID DESC");
    $newsitems->execute();
    $newsitem = $newsitems->fetchAll();
    $newsitems = NULL;
    foreach ($newsitem as $news) {
        echo '<div class="newsarticle"><div class="newspicture">';
        echo '<img src="/assets/images/' . $news["image"] . '" alt=' . $news["title"] . '>';
        echo '</div><div class="newstext"><div class="newstitle">';
        echo $news["title"];
        echo '</div>';
        shorten($news["description"], $descmax);
        echo '<a href="newsarticle.php?ID=?' . $news["ID"] . '" alt="' . $news["title"] . '">Lees meer!</a>';
        echo '</div></div>';
    }

}

?>
<section class="content content-news">
    <div class="heading">
    </div>
    <div class="main-news">
        <div class="news-category">
            <span class="title">Categorieën</span>
            <ul>
                <?php
                foreach ($newscategory as $category) {
                    if (isset($_GET['categorie'])) {
                        if ($category["name"] === $_GET['categorie']) {
                            $class = 'class="selected"';
                        } else {
                            $class = '';
                        }
                    }
                    echo '<li><a href="?categorie=' . $category["ID"] . '"' . $class . '>' . $category["name"] . ' (' . $category["amount"] . ')</a>';
                }
                if (isset($_GET["categorie"])) {
                    echo '<li><a href="/nieuws.php">Toon alles</a></li>';
                }
                ?>
            </ul>
        </div>
        <div class="news-item">
            <span class="title">Nieuws artikelen:</span>
            <?php
            news();

            ?>
        </div>
    </div>
</section>
<?php include('footer.php'); ?>

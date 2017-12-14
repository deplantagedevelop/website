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
    $newscategoryquery = ' WHERE nc.name = "' . $category . '"';
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
}

function news()
{
    global $conn, $descmax, $_GET, $newscategoryquery;
    $newsitems = $conn->prepare("SELECT n.ID, image, title, description FROM news AS n INNER JOIN newscategory AS nc ON n.categoryID = nc.ID" . $newscategoryquery . " ORDER BY n.ID DESC");
    $newsitems->execute();
    $newsitem = $newsitems->fetchAll();
    $newsitems = NULL;
    foreach ($newsitem as $news) {
        ?>
        <div class="newsarticle">
            <div class="newspicture">
                <img src="/assets/images/news/<?php echo $news["image"]; ?>" alt='<?php echo $news["title"]; ?> '>
            </div>
            <div class="newstext">
                <div class="newstitle"><?php echo $news["title"]; ?></div>
                <?php shorten($news["description"], $descmax); ?>
                <a href="artikel/<?php echo $news["ID"]; ?>" alt="'<?php echo $news["title"]; ?>'">Lees meer</a>
            </div>
        </div>
        <?php
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
                    ?>
                    <li><a href="?categorie=<?php echo $category["name"]; ?>" <?php echo $class; ?>> <?php echo $category["name"] . ' ('. $category["amount"] .')'; ?></a></li>
                <?php
                }
                if (isset($_GET["categorie"])) {
                    echo '<li><a href="/nieuws">Toon alles</a></li>';
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

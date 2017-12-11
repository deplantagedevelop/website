<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
$user = new User($conn);
if (!$user->is_loggedin()) {
    $user->redirect('/inloggen');
}
//vars
$descmax = 175;

//functions
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
    $newsitems = $conn->prepare("SELECT n.ID, nc.name, image, title, description FROM news AS n INNER JOIN newscategory AS nc ON n.categoryID = nc.ID" . $newscategoryquery . " ORDER BY n.ID DESC");
    $newsitems->execute();
    $newsitem = $newsitems->fetchAll();
    $newsitems = NULL;
    foreach ($newsitem as $news) {
        ?>
        <div class="newsarticle">
            <div class="news-upper">
                <div class="newstitle">
                    <?php echo $news["title"]; ?>
                </div>
                <div class="newstitle">
                    <?php echo $news["name"]; ?>
                </div>
            </div>
            <div class="news-lower">
                <div class="newspicture">
                    <img src="/assets/images/news/<?php echo $news["image"]; ?>" alt='<?php echo $news["title"]; ?> '>
                </div>
                <div class="newstext">
                    <?php shorten($news["description"], $descmax); ?>
                    <a href="artikel/<?php echo $news["ID"]; ?>" alt="'<?php echo $news["title"]; ?>'">Lees meer</a>
                </div>
                <div class="update">
                    <table>
                        <tr>
                            <td> <i class="fa fa-pencil-square-o" aria-hidden="true">::before</i></td><td><a href="update?id=<?php echo $news["ID"]?>">Bewerk</a></td>
                        </tr>
                        <tr>
                            <td><i class="fa fa-trash-o" aria-hidden="true"></i></td><td><a href="delete?id=<?php echo $news["ID"]?>">Verwijder</a></td>
                        </tr>
                    </table>
                </div>
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
            <div class="news-item">
                <a href="create.php">Maak een nieuws nieuwsartikel aan</a>
                <?php

                news();

                ?>
            </div>
        </div>
    </section>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
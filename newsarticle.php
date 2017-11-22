<?php
//notes:
//onchange="document.getElementById('formName').submit()" in de form


//includes:
include('header.php');
include('lib/connection.php');


//vars:
$ID = $_GET["ID"];


//functions:
$IDCHOP = substr($ID, 1);

?>
<section class="content content-news" >
    <div class="heading" >
    </div >
    <div class="main-newsarticle" >
        <?php

$newsitems = $conn->prepare("SELECT * FROM news WHERE ID ='" . $IDCHOP . "'");
$newsitems->execute();
$newsitem = $newsitems->fetchAll();
$newsitems = NULL;
foreach ($newsitem as $item) {
    echo '<div class="image"><img src="/assets/images/' . $item["image"] . '" alt=' . $item["title"] . '></div>';
    echo '<div class="news-text"></div><div class="title"><h2>' . $item["title"] . '</h2></div>';
    echo '<div class="description">' . $item["description"] . '</div></div>';

}

?>
</div>
</section>
<?php include('footer.php'); ?>

<?php
include('header.php');
include('lib/connection.php');

$ID = $_GET["ID"];
?>
<section class="content content-newsarticle" >
    <div class="heading" >
    </div >
    <div class="main-newsarticle" >
        <?php
            $newsitems = $conn->prepare("SELECT * FROM news WHERE ID ='" . $ID . "'");
            $newsitems->execute();
            $newsitem = $newsitems->fetchAll();
            $newsitems = NULL;
            foreach ($newsitem as $item) {
                echo '<div class="newsitem-text"></div><div class="title"><h2>' . $item["title"] . '</h2></div>';
                echo '<div class="newsitem-buttom">';
                echo '<div class="newsitem-image"><img src="/assets/images/news/' . $item["image"] . '" alt=' . $item["title"] . '></div>';
                echo '<div class="newsitem-description">' . $item["description"] . '</div></div>';
                echo '</div>';
            }
?>


    </div>
</section>
<?php include('footer.php'); ?>

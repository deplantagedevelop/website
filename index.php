<?php
    include('header.php');

    $newsitems = $conn->query('SELECT * FROM news ORDER BY ID DESC LIMIT 3');

?>
<section class="home-slider">
    <div class="slider">
        <div class="slide" style="background: url('assets/images/slider/slide2.jpg') no-repeat center center">

        </div>
        <div class="slide" style="background: url('assets/images/slider/slide1.jpg') no-repeat center center">

        </div>
    </div>
</section>
<section class="content">
    <div class="home-products">
        <div class="single-product">
            <div class="product-image" style="background-image: url('/assets/images/thee.jpg')">
                <div class="overlay">
                    <h2>Thee van de Maand</h2>
                </div>
            </div>
            <div class="product-info">
                <h2>Sensazione</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque metus, ultrices sit amet cursus id, suscipit at mi. Pellentesque sit amet semper orci. Vestibulum sed urna vel metus maximus eleifend a non purus. Aenean posuere massa nunc, quis bibendum dui mollis nec. Phasellus consectetur tempor pellentesque. Phasellus pellentesque tellus vitae justo dictum, eget scelerisque erat ornare. Nam non porttitor mauris, a egestas ligula. Fusce gravida aliquam quam eget venenatis. Quisque dapibus non dolor a pretium.</p>
            </div>
        </div>
        <div class="single-product">
            <div class="product-image" style="background-image: url('/assets/images/koffie.jpg')">
                <div class="overlay">
                    <h2>Koffie van de Maand</h2>
                </div>
            </div>
            <div class="product-info">
                <h2>Sensazione</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean neque metus, ultrices sit amet cursus id, suscipit at mi. Pellentesque sit amet semper orci. Vestibulum sed urna vel metus maximus eleifend a non purus. Aenean posuere massa nunc, quis bibendum dui mollis nec. Phasellus consectetur tempor pellentesque. Phasellus pellentesque tellus vitae justo dictum, eget scelerisque erat ornare. Nam non porttitor mauris, a egestas ligula. Fusce gravida aliquam quam eget venenatis. Quisque dapibus non dolor a pretium.</p>
            </div>
        </div>
    </div>
    <div class="home-news">
        <?php
            if ($newsitems->rowCount() > 0) {
                foreach ($newsitems as $newsitem) {
                    $description = (strlen($newsitem["description"]) > 125) ? substr($newsitem["description"], 0, 125) . '...' : $newsitem["description"];
                    ?>
                    <div class="single-news">
                        <div class="news-image" style="background-image: url('/assets/images/<?php echo $newsitem["image"]; ?>')"></div>
                        <div class="news-info">
                            <h2><?php echo $newsitem["title"]; ?></h2>
                            <p><?php echo $description; ?></p>
                            <a href="/" class="btn">Lees meer</a>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>
    </div>
</section>
<?php include('footer.php'); ?>

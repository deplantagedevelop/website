<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];

    $monthlyproduct = $conn->prepare("SELECT * FROM monthly_product WHERE ID= :id");
    $monthlyproduct->execute(array(
        ':id' => $id));

    while ($row = $monthlyproduct->fetch()) {
        $type = $row["type"];
        $title = $row["title"];
        $description = $row["description"];
        $image = $row["image"];
        ?>
        <a href="index.php"> Ga terug </a> <br> <br>
        <div class="home-products">
            <div class="single-product">
                <div class="product-image" style="background-image: url('/assets/images/monthlyproducts/<?php echo $image ?>')">
                    <div class="overlay">
                        <h2><?php echo $type; ?></h2>
                    </div>
                </div>
                <div class="product-info">
                    <h2><?php echo $title; ?></h2>
                    <p><?php echo $description; ?></p>
                </div>
            </div>
        </div>
<?php    } ?>

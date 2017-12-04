<?php include('header.php'); ?>
<section class="content main-content">
    <?php
        if(isset($_GET['id'])) {
            $id = $_GET['id'];

            $products = $conn->prepare('SELECT p.*, pc.name as category FROM products AS p INNER JOIN productcategory AS pc ON p.categoryID = pc.ID WHERE p.id = ' . $id);
            $products->execute();

            foreach ($products as $item) { ?>
                <div class="itembreadcrumb">
                    <a href="/shop">Producten /</a>
                    <a href="/shop?categorie=<?php echo $item["category"] ?>"><?php echo $item["category"] ?> /</a>
                    <h5><?php echo $item["title"] ?> </h5>
                </div>
                <div class="product-content">
                  <div class="mediacontent">
                      <div class="left-product">
                        <img src="/assets/images/products/<?php echo $item["image"]; ?>">
                      </div>
                    <div class="middle-product">
                        <h1 class="producttitle"> <?php echo $item["title"]; ?> </h1>
                        <div class="productundertitle"> <h4>Categorie:</h4><?php echo " " . $item["category"]; ?> </div>
                        <div class="itemdescription"> <h4>Beschrijving:</h4><?php echo " " . "<br>" . $item["description"]; ?> </div>
                    </div>
                  </div>
                    <div class="right-product">
                        <div class="itemprice">
                            <?php echo "€ " . $item["price"]; ?>
                        </div>
                        <div class="itemsubmit">
                            <button name="itemorder" type="submit" value="verzend">in winkelwagen</button>
                        </div>
                    </div>
                <?php
            }
        }
    ?>
</section>
<?php include('footer.php'); ?>

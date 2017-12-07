
<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);
    if($user->is_loggedin()) {
        if(isset($_GET['id'])) {
            $productID = $_GET['id'];
        } else {
            $productID = '';
        }

        $item = $conn->query('SELECT * FROM monthly_product WHERE ID = ' . $productID);

        foreach($item as $product) {
           ?>
            <h2 id="producttitel"><?php echo $product["type"]; ?></h2>
            <form id="form2" method="post" enctype="multipart/form-data">
                <p id="p1">Foto veranderen:</p> <br/>
                <img src="<?php echo $product["image"]; ?>" alt="<?php echo $product["type"]; ?>         ">
                <input type="file" name="image" id="image"><br/><br>
                <input id="titel" type="text" name="title" value="<?php echo $product["title"]; ?>" placeholder="Titel"><br><br>
                <textarea id="beschrijving" name="description" maxlength='500' placeholder="Beschrijving"><?php echo $product["description"]; ?></textarea><br><br>
                <button id="knop" onclick="myFunction()">Annuleren</button>
                <input id="knop" type="submit" value="Wijzigen">
            </form>


            <script>
                function myFunction() {
                    if (confirm("Wilt u echt annuleren?") == true) {
                        window.location = '/dashboard/monthlyproducts'
                    }
                }
            </script>

            <?php
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $title = $_POST['title'];
            $description = $_POST['description'];


            $update = $conn->prepare('UPDATE monthly_product SET title = "'. $title .'", description = "'. $description .'" WHERE ID = ' . $productID);
            $update->execute();
            $user->redirect($_SERVER['REQUEST_URI']);
        }
    } else {
        $user->redirect('/404');
    }
    ?>

<div id="preload">
   <img src="<?php echo $product["image"]; ?>" width="1" height="1" alt="<?php echo $product["type"]; ?>" />
</div>

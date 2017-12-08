<?php

include('header.php');

?>

<?php
    $reviews = $conn->prepare("SELECT * FROM reviews ORDER BY date DESC ");
    $gemiddelde = $conn->prepare("SELECT AVG(rating) FROM reviews");
    $aantalReviews = $conn->prepare("SELECT COUNT(*) FROM reviews");
?>

<?php
    $firstnameTrue=true;
    $lastnameTrue=true;
    $firstname = "";
    $middlename = "";
    $lastname="";
    $message="";
    $anonymous="3";
    $star="";
    $starsTrue = true;
    $send = "";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = array_map('strip_tags', $_POST);
        $firstnameTrue = false;
        $lastnameTrue = false;
        $starsTrue = false;
        $firstname = ucfirst($_POST["firstname"]);
        $middlename = $_POST["middlename"];
        $lastname = ucfirst($_POST["lastname"]);
        $anonymous = $_POST["anonymous"];
        $star = $_POST["star"];
        $message = ucfirst($_POST["message"]);
        if ($_POST["anonymous"] == 0) {
            if (empty($_POST["firstname"])) {
                $firstnameTrue = false;
            } else {
                $firstnameTrue = true;
            }
            if (empty($_POST["lastname"])) {
                $lastnameTrue = false;
            } else {
                $lastnameTrue = true;
            }
        } else {
            $firstnameTrue = true;
            $lastnameTrue = true;
        }
        if (empty($star)) {
            $starsTrue = false;
        } else {
            $starsTrue = true;
        }
        if ($firstnameTrue == true && $lastnameTrue == true && $starsTrue) {
            $stmt = $conn->prepare("INSERT INTO reviews(firstname, middlename, lastname, anonymous, rating, message) VALUES(:firstname, :middlename, :lastname, :anonymous, :star, :message)");
            $stmt->execute(array(
                ':firstname' => $firstname,
                ':middlename' => $middlename,
                ':lastname' => $lastname,
                ':anonymous' => $anonymous,
                ':star' => $star,
                ':message' => $message
            ));
            $send = true;
        }


    }
?>

<section class="content content-review">
    <div class="heading">
        <h2> Reviews </h2>
    </div>
    <div class="main-review">
        <div class="review-form">
            <form method="post">
                <div class="making-review">
                    <div class="review-info">
                        <input type="text" name="firstname" placeholder="Voornaam" value="<?php if($lastnameTrue == false || $starsTrue == false) { echo "$firstname"; }?>"> <?php if ($firstnameTrue == false) { echo "<span class='naamTrue'>invullen!</span>";} ?><br> <br>
                        <input type="text" name="middlename" placeholder="Tussenvoegsel" value="<?php if($firstnameTrue == false || $lastnameTrue == false || $starsTrue == false) {echo "$middlename";}?>"> <br> <br>
                        <input type="text" name="lastname" placeholder="Achternaam" value="<?php if($firstnameTrue == false || $lastnameTrue == false || $starsTrue == false) { echo "$lastname";}?>"> <?php if ($lastnameTrue == false) { echo "<span class='naamTrue'>invullen!</span>";}?><br> <br>
                        <p> Anoniem </p>
                        <input type="radio" name="anonymous" value="1" required <?php if($anonymous == 1){echo"checked=\"true\"";}?>><span> Ja </span>
                        <input type="radio" name="anonymous" value="0" <?php if ($anonymous==0){echo"checked=\"true\"";}?>><span> Nee </span> <br>
                    </div>
                    <div class="review">
                        Aantal sterren <br>
                        <!-- <input type="number" name="rating" placeholder="aantal sterren" required><br> -->
                        <div class="stars">
                                <input class="star star-5" id="star-5" type="radio" name="star" value="5" <?php if($star==5 && ($lastnameTrue == false || $starsTrue == false)){echo"checked=\"true\"";}?>>
                                <label class="star star-5" for="star-5"></label>
                                <input class="star star-4" id="star-4" type="radio" name="star" value="4" <?php if($star==4 && ($lastnameTrue == false || $starsTrue == false)){echo"checked=\"true\"";}?>>
                                <label class="star star-4" for="star-4"></label>
                                <input class="star star-3" id="star-3" type="radio" name="star" value="3" <?php if($star==3 && ($lastnameTrue == false || $starsTrue == false)){echo"checked=\"true\"";}?>>
                                <label class="star star-3" for="star-3"></label>
                                <input class="star star-2" id="star-2" type="radio" name="star" value="2" <?php if($star==2 && ($lastnameTrue == false || $starsTrue == false)){echo"checked=\"true\"";}?>>
                                <label class="star star-2" for="star-2"></label>
                                <input class="star star-1" id="star-1" type="radio" name="star" value="1" <?php if($star==1 && ($lastnameTrue == false || $starsTrue == false)){echo"checked=\"true\"";}?>>
                                <label class="star star-1" for="star-1"></label>
                        </div> <?php if ($starsTrue == false) { echo "<span class='starTrue'>Verplicht!</span>";}?>
                        <p> Toelichting <span class="max-300"> (Maximaal 300 tekens)</span> </p>
                        <textarea name="message" placeholder="Toelichting" required maxlength="300"><?php if($firstnameTrue == false || $lastnameTrue == false || $starsTrue == false) { echo "$message";};?></textarea> <br> <br>
                        <button type="submit" name="submit" value="plaatsen"> Plaatsen </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
        if ($send == true) { echo "bedankt voor uw review!";}
    ?>
    <div class="review-gem">
        <?php
            $gemiddelde->execute();
            $aantalReviews->execute();
            $aantal = 0;
            while ($row = $aantalReviews->fetch()) {
                $aantal = $row["COUNT(*)"];
            }

            if ($aantal != 0) {
                while ($row = $gemiddelde->fetch()) {
                    $gem = $row["AVG(rating)"];
                    $gem = round($gem);
                    for ($i = 0; $i < $gem; $i++) {
                        echo "<i class=\"fa fa-star fa-2x\" aria-hidden=\"true\"></i>";
                    }
                }
                echo "<br>";
                echo "$gem sterren uit $aantal reviews";
            } else {
                echo "Geen reviews aanwezig";
            }
        ?>
    </div>
    <div class="show-review">
        <?php
            $reviews->execute();
            while ($row = $reviews->fetch()) { 
                $firstname = $row["firstname"];
                $middlename = $row["middlename"];
                $lastname = $row["lastname"];
                $date = $row["date"];
                $anonymous = $row["anonymous"];
                $rating = $row["rating"];
                $message = $row["message"];
                if ($anonymous == 0) {
                    echo "<div class='review-left'> 
                            <span class='review-name'> $firstname $middlename $lastname</span> <br>
                            <span class='review-date'> $date </span> <br>";
                } else {
                    echo "<div class=\"review-left\">
                            <span class='review-name'> Anoniem </span> <br>
                            <span class='review-date'> $date </span> <br>";
                }
                echo "<div class='review-star'>";
                for ($i=0; $i<$rating; $i++) {
                    echo "<i class=\"fa fa-star fa-2x\" aria-hidden=\"true\"></i>";
                }
                echo "</div>";
                echo "<p> $message </p>";
                echo "</div>";
            }
        ?>
    </div>
</section>

<?php

include('footer.php');

?>



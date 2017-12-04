
        <?php
        include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
        $user = new User($conn);
        if(!$user->is_loggedin()) {
            $user->redirect('/inloggen');
        }
        if($user->has_role('Administrator')) {
            $reviews = $conn->prepare("SELECT * FROM reviews ORDER BY date DESC ");
            $gemiddelde = $conn->prepare("SELECT AVG(rating) FROM reviews");
            $aantalReviews = $conn->prepare("SELECT COUNT(*) FROM reviews");

            $gemiddelde->execute();

            while ($row = $gemiddelde->fetch()) {
                $gem = $row["AVG(rating)"];
                $gem = round($gem);
                for ($i=0; $i<$gem; $i++) {
                    echo "<i class=\"fa fa-star fa-2x\" aria-hidden=\"true\"></i>";
                }
            }
            echo "<br>";
            $aantalReviews->execute();
            while ($row = $aantalReviews->fetch()) {
                $aantal = $row["COUNT(*)"];
            }
            echo "$gem sterren uit $aantal reviews";

            $reviews->execute();
            echo '<div class="show-review">';
                while ($row = $reviews->fetch()) {
                    $id = $row["ID"];
                    $firstname = $row["firstname"];
                    $middlename = $row["middlename"];
                    $lastname = $row["lastname"];
                    $date = $row["date"];
                    $anonymous = $row["anonymous"];
                    $rating = $row["rating"];
                    $message = $row["message"];
                    echo " <div class='review-left'> 
                              <div class='top-buttons-review'> <div class='cross'><button onclick=\"myFunction()\"> Verwijderen </button> </div></div>
                              <div class='review-middle'> ";
                    if ($anonymous == 0) {
                        echo " <span class='review-name'> $firstname $middlename $lastname</span> <br>
                                <span class='review-date'> $date </span> <br>";
                    } else {
                        echo "<span class='review-name'> Anoniem </span> <br>
                                <span class='review-date'> $date </span> <br>";
                    }
                    echo "<div class='review-star'>";
                    for ($i = 0; $i < $rating; $i++) {
                        echo "<i class=\"starsrating fa fa-star fa-2x\" aria-hidden=\"true\"></i>";
                    }
                    echo "</div>";
                    echo "<div class='review-message'><span> $message </span> </div>";
                    echo "</div>";
                    echo "<div class='buttom-buttons-review'></div>";
                    echo "</div>";
                }
                echo '</div>';
        }
        include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
        ?>

        <script>
            function myFunction() {
                if (confirm("Weet je zeker dat je de review wilt verwijderen?") == true) {
                    window.location.href = "delete.php/?id=. "
                }
            }
        </script>



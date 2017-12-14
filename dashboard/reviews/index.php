<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);
    if (!$user->is_loggedin()) {
        $user->redirect('/inloggen');
    }
    if ($user->has_role('Administrator')) {
        $reviews = $conn->prepare("SELECT * FROM reviews ORDER BY date DESC ");
        $gemiddelde = $conn->prepare("SELECT AVG(rating) FROM reviews");
        $aantalReviews = $conn->prepare("SELECT COUNT(*) FROM reviews");

        $gemiddelde->execute();
        $aantalReviews->execute();
        $aantal = 0;
        while ($row = $aantalReviews->fetch()) {
            $aantal = $row["COUNT(*)"];
        }
        echo "<div class='gem'>";
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
            echo "geen reviews aanwezig";
        }
        echo "</div>";
        ?>
        <table class="review-table">
            <thead> <tr> <th> Naam </th> <th> Datum </th> <th> Aantal sterren </th> <th> Bekijken </th> <th> Wijzigen </th> <th> verwijderen </th> </tr> </thead>
            <tbody>
        <?php
        $reviews->execute();
        while ($row = $reviews->fetch()) {
            $id = $row["ID"];
            $firstname = $row["firstname"];
            $middlename = $row["middlename"];
            $lastname = $row["lastname"];
            $date = $row["date"];
            $anonymous = $row["anonymous"];
            $rating = $row["rating"];
            $message = $row["message"];
            echo "<tr>";
            if ($anonymous == 1) {
                echo "<td> Anoniem</td>";
            } else {
                echo "<td> $firstname $middlename $lastname";
            }
            echo "<td> $date </td><td>";
            for ($i = 0; $i < $rating; $i ++) {
                echo "<i class=\"starsrating fa fa-star\" aria-hidden=\"true\"></i>";
            }
            echo"</td>";
            echo "<td> <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> <a href=\"/dashboard/reviews/review?id=$id\">Bekijken</a></td>";
            echo "<td><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <a href=\"/dashboard/reviews/react?id=$id\">Reageren</a></td>";
            echo "<td><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i> <a href=\"/dashboard/reviews/delete?id=$id\" onclick=\"return confirm('Weet je zeker dat je het wilt verwijderen?');\">Verwijder</a></td>";
            echo "</tr>";
        }
        ?>
            </tbody>
        </table>
        <?php
    }

    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
?>




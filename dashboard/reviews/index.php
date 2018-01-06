<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);

    if ($user->has_role('Administrator')) {
        //Check for page request
        $limit = 20;
        if(empty($_GET['pagina'])) {
            $currentRow = 0;
            $_GET['pagina'] = 0;
        } else {
            if(is_numeric($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
                $currentRow = ($pagina - 1) * $limit;
            } else {
                $user->redirect('/dashboard/reviews');
            }
        }

        $reviews = $conn->prepare("SELECT * FROM reviews ORDER BY date DESC  LIMIT " . $currentRow . ", " . $limit);
        $gemiddelde = $conn->prepare("SELECT AVG(rating) FROM reviews");
        $gemiddelde->execute();
        $aantalReviews = $conn->prepare("SELECT COUNT(*) AS amount FROM reviews");
        $aantalReviews->execute();
        $rowCount = $aantalReviews->fetch(PDO::FETCH_ASSOC);
        $total_pages = ceil($rowCount['amount'] / $limit);

        $reviews->execute();
        if ($reviews->rowCount() > 0) {
            ?>
            <table class="dash-table tableresp tablereviews">
                <thead>
                <tr>
                    <th> Naam</th>
                    <th class="reviewdate"> Datum</th>
                    <th class="reviewstars"> Aantal sterren</th>
                    <th> Bekijken</th>
                    <th> Wijzigen</th>
                    <th> verwijderen</th>
                </tr>
                </thead>
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
                        echo "<td class='reviewdate'> $date </td><td class='reviewstars'>";
                        for ($i = 0; $i < $rating; $i ++) {
                            echo "<i class=\"starsrating fa fa-star\" aria-hidden=\"true\"></i>";
                        }
                        echo "</td>";
                        echo "<td> <i class=\"fa fa-eye\" aria-hidden=\"true\"></i> <a href=\"/dashboard/reviews/review?id=$id\">Bekijken</a></td>";
                        echo "<td><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <a href=\"/dashboard/reviews/react?id=$id\">Reageren</a></td>";
                        echo "<td><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i> <a href=\"/dashboard/reviews/delete?id=$id\" onclick=\"return confirm('Weet je zeker dat je het wilt verwijderen?');\">Verwijder</a></td>";
                        echo "</tr>";
                    }
                ?>
                </tbody>
            </table>
            <?php
            $aantal = $rowCount['amount'];
            ?>
            <div class="flex-pagination">
                <?php
                if ($_GET['pagina']) {
                    $current = $_GET['pagina'];
                    if ($current != 1) {
                        echo '<a href="/dashboard/reviews"> << </a>';
                        echo '<a href="?pagina=' . ($current - 1) .'"> < </a>';
                    }
                } else {
                    $current = 1;
                }

                for ($i = $current; $i <= $current + 2; $i++) {
                    if ($_GET['pagina'] == $i) {
                        echo '<a href="?pagina=' . $i . '" class="current">' . $i . '</a>';
                    } elseif (empty($_GET['pagina']) && $i === 1) {
                        echo '<a href="?pagina=' . $i . '" class="current">' . $i . '</a>';
                    } else {
                        if ($current != $total_pages) {
                            if ($current != $total_pages - 1) {
                                echo '<a href="?pagina=' . $i . '">' . $i . '</a>';
                            }
                        }
                    }
                }
                if ($_GET['pagina'] != $total_pages) {
                    if ($current <= $total_pages - 3) {
                        echo '<a href="#">...</a>';
                        echo '<a href="?pagina=' . $total_pages . '">' . $total_pages . '</a>';
                    }
                    if ($current == $total_pages - 1) {
                        echo '<a href="?pagina=' . $total_pages . '">' . $total_pages . '</a>';
                    }
                    if ($current != $total_pages) {
                        echo '<a href="?pagina=' . ($current + 1) . '"> > </a>';
                        echo '<a href="?pagina=' . $total_pages . '"> >> </a>';
                    }
                }
                ?>
            </div>
            <div class='gem'>
            <?php
            if ($aantal != 0) {
                while ($row = $gemiddelde->fetch()) {
                    $gem = $row["AVG(rating)"];
                    $gem = round($gem);
                    for ($i = 0; $i < $gem; $i ++) {
                        echo "<i class=\"fa fa-star fa-2x\" aria-hidden=\"true\"></i>";
                    }
                }
                echo "<br>";
                echo "$gem sterren uit $aantal reviews";
            }
            ?>
            </div>
            <?php
        } else {
            echo "geen reviews aanwezig";
        }
    }

    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
?>




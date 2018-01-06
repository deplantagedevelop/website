<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');

    $limit = 20;
    if(empty($_GET['pagina'])) {
        $currentRow = 0;
        $_GET['pagina'] = 0;
    } else {
        if(is_numeric($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
            $currentRow = ($pagina - 1) * $limit;
        } else {
            $user->redirect('/dashboard/news');
        }
    }

    $newsitems = $conn->prepare("SELECT n.*, nc.name AS category FROM news AS n INNER JOIN newscategory AS nc ON n.categoryID = nc.ID ORDER BY n.ID DESC LIMIT " . $currentRow . ", " . $limit);
    $newsitems->execute();

    $rowCounts = $conn->prepare('SELECT COUNT(*) AS amount FROM news');
    $rowCounts->execute();
    $rowCount = $rowCounts->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($rowCount['amount'] / $limit);

    if ($newsitems->rowCount() > 0) {
        ?>
        <a href="/dashboard/news_category" class="back-btn"><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp;
            Categorieën</a>
        <div class="content">
            <table class="dash-table tableresp">
                <thead>
                <tr>
                    <th>Titel</th>
                    <th class="categorynews">Categorie</th>
                    <th class="newsactive">Actief</th>
                    <th class="newsdate">Datum</th>
                    <th>Bewerken</th>
                    <th>Verwijderen</th>
                </tr>
                </thead>
                <tbody>
                <?php
                    foreach ($newsitems as $item) {
                        ?>
                        <tr>
                            <td><?php echo $item['title']; ?></td>
                            <td class="categorynews"><?php echo $item['category']; ?></td>
                            <td class="newsactive"><?php echo ($item['active'] == 1) ? 'Ja' : 'Nee'; ?></td>
                            <td class="newsdate"><?php echo $item['date']; ?></td>
                            <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a
                                        href="/dashboard/news/update?id=<?php echo $item['ID']; ?>">Bewerk</a></td>
                            <td><i class="fa fa-trash-o" aria-hidden="true"></i> <a
                                        href="/dashboard/news/delete?id=<?php echo $item['ID']; ?>"
                                        onclick="return confirm('Weet u zeker dat u het newsartikel wil verwijderen?');">Verwijder</a>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
                </tbody>
            </table>
        </div>
        <div class="flex-pagination">
            <?php
            //Reset category Get because of products, only check for get in URL now.
            if ($_GET['pagina']) {
                $current = $_GET['pagina'];
                if ($current != 1) {
                    echo '<a href="/dashboard/news"> << </a>';
                    echo '<a href="?pagina=' . ($current - 1) . '"> < </a>';
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
        <?php
    } else {
        echo '<p>Geen nieuwsberichten gevonden</p>';
    }
    ?>
    <a href="/dashboard/news/create" class="create-btn">Nieuws toevoegen</a>
    <?php

    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
$user = new User($conn);

$newsitems = $conn->prepare("SELECT n.*, nc.name AS category FROM news AS n INNER JOIN newscategory AS nc ON n.categoryID = nc.ID ORDER BY n.ID DESC");
$newsitems->execute();
if ($newsitems->rowCount() > 0) {
    ?>
    <a href="/dashboard/news_category" class="back-btn"><i class="fa fa-arrow-right" aria-hidden="true"></i>&nbsp; Categorieën</a>
    <div class="content">
        <table class="dash-table">
            <thead>
            <tr>
                <th>Titel</th>
                <th>Categorie</th>
                <th>Actief</th>
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
                        <td><?php echo $item['category']; ?></td>
                        <td><?php echo ($item['active'] == 1) ? 'Ja' : 'Nee'; ?></td>
                        <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a href="/dashboard/news/update?id=<?php echo $item['ID']; ?>">Bewerk</a></td>
                        <td><i class="fa fa-trash-o" aria-hidden="true"></i> <a href="/dashboard/news/delete?id=<?php echo $item['ID']; ?>" onclick="return confirm('Weet u zeker dat u het newsartikel wil verwijderen?');">Verwijder</a></td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
    </div>
    <?php
} else {
    echo '<p>Geen nieuwsberichten gevonden</p>';
}
?>
    <a href="/dashboard/news/create" class="create-btn">Nieuws toevoegen</a>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
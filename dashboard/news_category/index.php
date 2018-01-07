<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);

    $newscategory = $conn->prepare("SELECT * FROM newscategory");
?>
    <a href="/dashboard/news" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
    <div class="content">
        <table class="dash-table tableresp">
            <thead>
            <tr>
                <th> Categorienaam </th>
                <th> Bewerken </th>
                <th> Verwijderen </th>
            </tr>
            </thead>
            <?php
                $newscategory->execute();
                echo "<tbody>";
                while ($row = $newscategory->fetch()) {
                    $id = $row["ID"];
                    $name = $row["name"];
                    $active = $row["checked"];
                    if ($active == "true") {
                        echo "<tr> 
                    <td> $name </td> 
                    <td><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <a href=\"update?id=$id\">Bewerk</a></td>
                    <td><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i> <a href=\"delete.php/?id=$id\" onclick=\"return confirm('Weet je zeker dat je het wilt verwijderen?');\">Verwijder</a></td>                
                  </tr>";
                    } else {
                        echo "<tr>
                    <td> $name </td>
                    <td><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <a href=\"update?id=$id\">Bewerk</a></td>
                    <td><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i> <a href=\"delete.php/?id=$id\" onclick=\"return confirm('Weet je zeker dat je het wilt verwijderen?');\">Verwijder</a></td>
                  </tr>";
                    }
                }
                echo "</tbody>";
            ?>
        </table>
    </div>
    <a href="/dashboard/news_category/create" class="create-btn">Categorie toevoegen</a>

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

?>
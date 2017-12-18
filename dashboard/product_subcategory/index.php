<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);
    if (!$user->is_loggedin()) {
        $user->redirect('/inloggen');
    }
    $productsubcategory = $conn->prepare("SELECT * FROM productsubcategory");
?>
    <a href="/dashboard/product_category" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
    <div class="content">
        <table class="dash-table">
            <thead>
            <tr>
                <th> Subcategorienaam </th>
                <th> Categorie </th>
                <th> Actief </th>
                <th> Bewerken </th>
                <th> Verwijderen </th>
            </tr>
            </thead>
            <?php
                $productsubcategory->execute();
                echo "<tbody>";
                while ($row = $productsubcategory->fetch()) {
                    $id = $row["ID"];
                    $name = $row["name"];
                    $active = $row["checked"];
                    $category = $row["categoryID"];
                    if ($active == "true") {
                        echo "<tr> 
                    <td> $name </td> 
                    <td> $category </td>
                    <td> Actief </td> 
                    <td><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <a href=\"update?id=$id\">Bewerk</a></td>
                    <td><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i> <a href=\"delete.php/?id=$id\" onclick=\"return confirm('Weet je zeker dat je het wilt verwijderen?');\">Verwijder</a></td>                
                  </tr>";
                    } else {
                        echo "<tr>
                    <td> $name </td>
                    <td> $category </td>
                    <td> Non-actief </td>
                    <td><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <a href=\"update?id=$id\">Bewerk</a></td>
                    <td><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i> <a href=\"delete.php/?id=$id\" onclick=\"return confirm('Weet je zeker dat je het wilt verwijderen?');\">Verwijder</a></td>
                  </tr>";
                    }
                }
                echo "</tbody>";
            ?>
        </table>
    </div>
    <a href="/dashboard/product_subcategory/create" class="create-btn">Subcategorie toevoegen</a>

<?php
include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

?>
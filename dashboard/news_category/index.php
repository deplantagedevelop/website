<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);
    if (!$user->is_loggedin()) {
        $user->redirect('/inloggen');
    }
    $newscategory = $conn->prepare("SELECT * FROM newscategory");
?>

<table class="newscategory-table">
    <thead><tr> <th> Categorienaam </th> <th> Actief </th> <th> Bewerken </th> <th> Verwijderen </th></tr> </thead>
<?php
    $newscategory->execute();
    echo "<tbody>";
    while ($row = $newscategory->fetch()) {
        $id = $row["ID"];
        $name = $row["name"];
        $active = $row["checked"];
        if ($active == "true") {
            echo "<tr> 
                    <td class='news_category_name'> $name </td> 
                    <td> Actief </td> 
                    <td><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <a href=\"update?id=$id\">Bewerk</a></td>
                    <td><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i> <a href=\"delete.php/?id=$id\" onclick=\"return confirm('Weet je zeker dat je het wilt verwijderen?');\">Verwijder</a></td>                
                  </tr>";
        } else {
            echo "<tr>
                    <td class='news_category_name'> $name </td>
                    <td> Non-actief </td>
                    <td><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i> <a href=\"update?id=$id\">Bewerk</a></td>
                    <td><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i> <a href=\"delete.php/?id=$id\" onclick=\"return confirm('Weet je zeker dat je het wilt verwijderen?');\">Verwijder</a></td>
                  </tr>";
        }
    }
    echo "</tbody>";
?>
</table>
    <a  class="insert_newscategory" href="create">Nieuws categorie toevoegen</a>
<?php
include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

?>
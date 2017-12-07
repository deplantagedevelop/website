<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];
    $changed = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $changed = true;
        $update_newscategory = $conn->prepare("UPDATE newscategory SET name=:name, checked=:active WHERE ID= :id");
        $update_newscategory->execute(array(
            ':name' => ucfirst($_POST["newscategoryname"]),
            ':active' => $_POST["active"],
            ':id' => $id
        ));
    }
    $newscategory = $conn->prepare("SELECT * FROM newscategory WHERE ID= :id");
    $newscategory->execute(array(
        ':id' => $id
    ));
    while ($row = $newscategory->fetch()) {
        $newscategory_name = $row["name"];
        $active = $row["checked"];
    }

?>

<a href="/dashboard/news_category"> ga terug </a> <br> <br>

<form class="newscategory-form" method="post">
    <span> Categorienaam: </span> <br>
    <input type="text" name="newscategoryname" value="<?php echo "$newscategory_name" ?>"> <br> <br>
    <span> Actief: </span> <br>
    <input type="radio" name="active" value="true" <?php if($active == "true"){echo"checked='true'";}?>> Ja
    <input type="radio" name="active" value="false" <?php if($active == "false"){echo"checked='true'";}?>> Nee <br> <br>
    <input type="submit" name="submit" value="wijzigen">
</form>

<?php
    if ($changed) {
        echo "Uw wijzigen zijn opgeslagen! <a href='index.php'>  Terug naar nieuwscategorieën </a>";
    }
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

?>

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

<a href="/dashboard/news" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
<div class="content">
    <div class="dashboard-left">
        <form method="post">
            <label>Categorienaam</label>
            <input type="text" name="newscategoryname" value="<?php echo "$newscategory_name" ?>">
            <span> Actief: </span><br>
            <input type="radio" name="active" value="true" class="radio-btn" <?php if($active == "true"){echo"checked='true'";}?>> Ja
            <input type="radio" name="active" value="false" class="radio-btn" <?php if($active == "false"){echo"checked='true'";}?>> Nee <br> <br>
            <input type="submit" name="submit" value="wijzigen">
        </form>
    </div>
</div>

<?php
    if ($changed) {
        echo "Uw wijzigen zijn opgeslagen!";
    }
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');

?>

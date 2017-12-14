<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];
    $changed = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $changed = true;
        $update_productcategory = $conn->prepare("UPDATE productcategory SET name=:name, checked=:active WHERE ID= :id");
        $update_productcategory->execute(array(
            ':name' => ucfirst($_POST["productcategoryname"]),
            ':active' => $_POST["active"],
            ':id' => $id
        ));
    }
    $productcategory = $conn->prepare("SELECT * FROM productcategory WHERE ID= :id");
    $productcategory->execute(array(
        ':id' => $id
    ));
    while ($row = $productcategory->fetch()) {
        $productcategory_name = $row["name"];
        $active = $row["checked"];
    }

?>

<a href="/dashboard/product_category" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
<div class="content">
    <div class="dashboard-left">
        <form method="post">
            <label>Categorienaam</label>
            <input type="text" name="productcategoryname" value="<?php echo "$productcategory_name" ?>">
            <span> Actief: </span><br>
            <input type="radio" name="active" value="true" class="radio-btn" <?php if($active == "true"){echo"checked='true'";}?>> Ja
            <input type="radio" name="active" value="false" class="radio-btn" <?php if($active == "false"){echo"checked='true'";}?>> Nee <br> <br>
            <input type="submit" name="submit" value="Wijzigen">
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

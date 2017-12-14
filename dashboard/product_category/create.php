<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);
    if (!$user->is_loggedin()) {
        $user->redirect('/inloggen');
    }
    $insert = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $insert = true;
        $insert_productcategory = $conn->prepare("INSERT INTO productcategory(name, checked) VALUES(:category_name, :checked)");
        $insert_productcategory->execute(array(
            ':category_name' => ucfirst($_POST["category_name"]),
            ':checked' => $_POST["active"]));
    }
?>

<a href="/dashboard/product_category" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a><br>
<div class="content">
    <div class="dashboard-left">
        <form method="post">
            <label>Categorie</label>
            <input type="text" name="category_name" placeholder="Categorienaam" required>
            <span> Actief of non-actief: </span> <br>
            <input type="radio" name="active" class="radio-btn" value="true" checked="checked" required> Actief
            <input type="radio" name="active" class="radio-btn" value="false"> Non-actief <br>
            <input type="submit" name="submit" value="Toevoegen">
        </form>
    </div>
</div>

<?php
    if ($insert) {
        echo "Productcategorie is toegevoegd!";
    }
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
?>

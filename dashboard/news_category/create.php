<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $user = new User($conn);
    if (!$user->is_loggedin()) {
        $user->redirect('/inloggen');
    }
    $insert = false;
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $insert = true;
        $insert_newscategory = $conn->prepare("INSERT INTO newscategory(name, checked) VALUES(:category_name, :checked)");
        $insert_newscategory->execute(array(
            ':category_name' => ucfirst($_POST["category_name"]),
            ':checked' => $_POST["active"]));
    }
?>

<a href="index.php"> Ga terug </a> <br> <br>

<div class="newscategory-form">
    <form method="post">
        <span> Categorie naam: </span> <br>
        <input type="text" name="category_name" placeholder="categorie naam" required> <br>
        <span> Actief of non-actief: </span> <br>
        <input type="radio" name="active" value="true" required> Actief <input type="radio" name="active" value="false"> Non-actief <br>
        <input type="submit" name="submit" value="toevoegen">
    </form>
</div>

<?php
    if ($insert) {
        echo "De nieuwscategorie is toegevoegd! <a href='index.php'>    Terug naar nieuwscategorie </a>";
    }
?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
?>

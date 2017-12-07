<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
$user = new User($conn);
$product = new Product($conn);
?>
<?php
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $contact = $conn->prepare('SELECT * FROM contact WHERE id = ' . $id);
    $contact->execute();

    foreach ($contact as $formulier) {
        ?>
        <div class="formulierinfo">
            <div class="formulierheader">
                <div class="formulierback">
                    <a href="/dashboard/news" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
                </div>
                <div class="formuliertitle">
                    <h1>Contactformulier</h1>
                </div>
                <div class="formulierdelete">
                    <a href="/dashboard/contact/delete?id=<?php echo $formulier['ID']; ?>" name="contactdelete" class="back-btn" onclick="return confirm('Weet u zeker dat u het contactformulier wil verwijderen?');"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp; Verwijder</a>
                </div>
            </div><br>
            <div class="formblock formbl">
                <h4>Naam</h4>
                <a> <?php echo $formulier['firstname'] . " " . $formulier['middlename'] . " " . $formulier['lastname']; ?> </a>
            </div>

            <div class="formblock formbl">
                <h4>Email</h4>
                <a> <?php echo $formulier['email']; ?> </a>
            </div>

            <div class="formblock formbl">
                <h4>Telefoonnummer</h4>
                <a> <?php echo $formulier['phonenumber']; ?> </a>
            </div>

            <div class="formblock formbl">
                <h4>Onderwerp</h4>
                <a> <?php echo $formulier['subject']; ?> </a>
            </div>

            <div class="formblock messageblock">
                <h4>Bericht</h4>
                <a> <?php echo $formulier['message']; ?> </a>
            </div>
<?php
    }
}
?>
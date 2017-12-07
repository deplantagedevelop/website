<?php include('header.php');

$succes = false;
$emailerror = false;
$loginerror = false;

if($user->is_loggedin() != "")
{
    if($user->has_role('Administrator')) {
        $user->redirect('/dashboard');
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitlogin'])) {
    $email = $_POST['loginemail'];
    $password = $_POST['loginpassword'];

    if($user->login($email, $password)) {
        if($user->has_role('Administrator')) {
            $user->redirect('/dashboard');
        }
        $succeslogin = true;
    } else {
        $loginerror = true;
    }
}

$firstname = '';
$middlename = '';
$lastname = '';
$email = '';
$phonenumber = '';
$address = '';
$city = '';
$postalcode = '';
$repassword = '';

$validationpassword = false;

if (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['register'])) {

    $firstname = $_POST["firstname"];
    $middlename = $_POST["middlename"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phonenumber = $_POST["phonenumber"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $postalcode = $_POST["postalcode"];
    $password = $_POST["password"];
    $repassword = $_POST["repassword"];

    if (7 < strlen($password)){
        if( preg_match("#[0-9]+#", $password) || preg_match("#\W+#", $password) ) {
            if( preg_match("#[a-z]+#", $password) ) {
                if( preg_match("#[A-Z]+#", $password) ) {
                    $validationpassword = true;
                }
            }
        }
    }

    if ($password == $repassword && $validationpassword == true) {
        try {
            $useremail = $conn->prepare("SELECT email FROM customer WHERE email = :email");
            $useremail->execute(array(':email'=>$email));
            $emailexists = $useremail->fetch(PDO::FETCH_ASSOC);

            if($emailexists['email'] == $email) {
                $emailerror = true;
            } else {
                $user->register($firstname, $middlename, $lastname, $email, $phonenumber, $address, $city, $postalcode, $password);

                $toklant = $email;
                $subjectklant = 'Bevestiging registratie';
                $messageklant = 'Hallo ' . $firstname . ', <br><br>
                                                bedankt voor het registreren op onze site.<br>
                                                Vanaf nu kunt u inloggen en bestellingen maken.<br><br><br>
                                                de Plantage<br>
                                                Bloemstraat 22<br>
                                                8081 CW, Elburg<br>
                                                0525-842787<br>
                                                info@deplantage-elburg.nl<br><br>
                                                <img width="250" src="http://jeffrey.plantagedevelopment.nl/assets/images/logo.png" alt="de Plantage"><br>';
                $headers[] = 'From: de Plantage Elburg <no-reply@plantagedevelopment.nl>' . "\r\n" .
                    'Reply-To: info@plantagedevelopment.nl' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
                $headers[] = 'MIME-Version: 1.0';
                $headers[] = 'Content-type: text/html; charset=iso-8859-1';

                mail($toklant, $subjectklant, $messageklant, implode("\r\n", $headers));

                $firstname = '';
                $middlename = '';
                $lastname = '';
                $email = '';
                $phonenumber = '';
                $address = '';
                $city = '';
                $postalcode = '';
                $repassword = '';

                $succes = true;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>

<section class="content main-content">
    <div class="full-content">
        <div class="login">
            <div class="headertext">
                <h2>Login</h2>
            </div>
            <form method="post">
                <input type="email" name="loginemail" placeholder="E-mail*" required><br><br>
                <input type="password" name="loginpassword" placeholder="Wachtwoord*"><br><br>
                <div class="loginsubmit">
                    <button name="submitlogin" type="submit" value="verzend">Inloggen</button>
                </div>
            </form>
            <?php
                if ($loginerror === true) {
                    echo "<div class='sentregister'>";
                    echo "De door u ingevoerde inloggegevens kloppen niet!";
                    echo "</div>";
                }
            ?>
        </div>

        <div class="register">
            <div class="headertext">
                <h2>Registreren</h2>
            </div>

            <form method="post">
                <input type="text" name="firstname" placeholder="Naam*" value="<?php echo $firstname ?>" required><br><br>
                <input type="text" name="middlename" placeholder="Tussenvoegsel" value="<?php echo $middlename ?>"><br><br>
                <input type="text" name="lastname" placeholder="Achternaam*" value="<?php echo $lastname ?>"><br><br>
                <input type="email" name="email" placeholder="E-mail*" value="<?php echo $email ?>" required><br><br>
                <input type="text" name="phonenumber" placeholder="Telefoonnummer" value="<?php echo $phonenumber ?>"><br><br>
                <input type="text" name="address" placeholder="Straat + Huisnummer*" value="<?php echo $address ?>" required><br><br>
                <input type="text" name="city" placeholder="Woonplaats*" value="<?php echo $city ?>" required><br><br>
                <input type="text" name="postalcode" placeholder="Postcode*" value="<?php echo $postalcode ?>" required><br><br>
                <input class="password" type="password" id="password1" name="password" placeholder="Wachtwoord*" required><br><br>
                <input class="password" type="password" id="password2" name="repassword" placeholder="Bevestig wachtwoord*" required><br><br>
                <div class="helper-text">
                    <ul>
                        <li class="length">Minimaal 8 karakters</li>
                        <li class="lowercase">Minimaal 1 kleine letter</li>
                        <li class="uppercase">Minimaal 1 hoofdletter</li>
                        <li class="special">Minimaal 1 getal of speciaal karakter</li>
                        <li class="same-pass">Wachtwoorden komen overeen</li>
                    </ul>
                </div><br>

                <div class="loginsubmit">
                    <button name="register" type="submit" value="verzend">Registreren</button>
                </div>

                <?php
                if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
                    echo "<div class='sentregister'>";
                    if ($succes === true) {
                        echo "U bent geregistreerd, u kunt vanaf nu inloggen!";
                    } elseif($emailerror === true) {
                        echo "Er is al een account met het door uw ingevoerde emailadres!";
                    } else {
                        echo "Het wachtwoord voldoet niet aan de eisen!";
                    }
                    echo "</div>";
                }
                ?>
            </form>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>

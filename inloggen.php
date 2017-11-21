<?php include('header.php'); ?>
<section class="content main-content">

    <div class="full-content">

        <div class="login">
            <div class="headertext">
                <h2>Login</h2>
            </div>
            <form method="post">
                <input type="email" name="email" placeholder="E-mail*" required><br><br>
                <input type="password" name="password" placeholder="Wachtwoord*"><br><br>
                <div class="loginsubmit">
                    <button name="submit" type="submit" value="verzend">Inloggen</button>
                </div>
            </form>

        </div>

        <div class="register">
            <div class="headertext">
                <h2>Registreren</h2>
            </div>

            <form method="post">
                <input type="text" name="firstname" placeholder="Naam*" required><br><br>

                <input type="text" name="middlename" placeholder="Tussenvoegsel"><br><br>

                <input type="text" name="lastname" placeholder="Achternaam*" required><br><br>

                <input type="email" name="email" placeholder="E-mail*" required><br><br>

                <input type="text" name="phonenumber" placeholder="Telefoonnummer"><br><br>

                <input type="text" name="address" placeholder="Straat + Huisnummer*" required><br><br>

                <input type="text" name="city" placeholder="Woonplaats*" required><br><br>

                <input type="text" name="postalcode" placeholder="Postcode*" required><br><br>

                <input div="password" type="password" id="password1" name="password" placeholder="Wachtwoord*" required><br><br>

                <input div="verify" type="password" id="password2" name="repassword" placeholder="Bevestig wachtwoord*" required><br>

                <?php
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

                $uppercase = preg_match('@[A-Z]@', $password);
                $lowercase = preg_match('@[a-z]@', $password);
                $number    = preg_match('@[0-9]@', $password);

                ?>

                <div class="requirements">
                    <div class="validate-status">

                    </div>
                    <ul>
                        <li>Minimaal 8 karakters</li>
                        <li>Minimaal 1 hoofdletter</li>
                        <li>Minimaal 1 kleine letter</li>
                        <li>Minimaal 1 getal</li>
                        <li>Wachtwoorden komen overeen</li>
                    </ul>
                </div>

                <div class="loginsubmit">
                    <button name="submit" type="submit" value="verzend">Registreren</button>
                </div>
            </form>
        <?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($password == $repassword && strlen($password) >= 8 && $number && $lowercase && $uppercase) {
                                $sql = "INSERT INTO customer (firstname, middlename, lastname, email, phonenumber, address, city, postalcode, password) 
                                VALUES (:firstname, :middlename, :lastname, :email, :phonenumber, :address, :city, :postalcode, :password)";
                                $stm = $conn->prepare($sql);
                                $stm->execute(array(
                                    ':firstname' => $firstname,
                                    ':middlename' => $middlename,
                                    ':lastname' => $lastname,
                                    ':email' => $email,
                                    ':phonenumber' => $phonenumber,
                                    ':address' => $address,
                                    ':city' => $city,
                                    ':postalcode' => $postalcode,
                                    ':password' => $repassword,
                                ));

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
                                                <img width="250" src="http://jeffrey.plantagedevelopment.nl/assets/images/logo.png" alt="de Plantage"><br>
                                                ';
                                $headers[] = 'From: de Plantage Elburg <no-reply@plantagedevelopment.nl>' . "\r\n" .
                                    'Reply-To: info@plantagedevelopment.nl' . "\r\n" .
                                    'X-Mailer: PHP/' . phpversion();
                                $headers[] = 'MIME-Version: 1.0';
                                $headers[] = 'Content-type: text/html; charset=iso-8859-1';

                                mail($toklant, $subjectklant, $messageklant, implode("\r\n", $headers));

                                echo "Uw account is aangemaakt!";

                    } else {
                echo "Wachtwoord voldoet niet aan de eisen!";
            }
        }


        ?>


        </div>
    </div>
</section>

<?php include('footer.php'); ?>

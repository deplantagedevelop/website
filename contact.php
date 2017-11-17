<?php include('header.php'); ?>
<section class="content main-content">
    <div class="heading">
        <h2>Contactformulier</h2>
    </div>
    <div class="main-contact">
        <div class="contact-form">
            <form method="post">

                <input type="text" name="firstname" placeholder="Naam*" required><br><br>

                <input type="text" name="middlename" placeholder="Tussenvoegsel"><br><br>

                <input type="text" name="lastname" placeholder="Achternaam*" required><br><br>

                <input type="email" name="email" placeholder="E-mail*" required><br><br>

                <input type="text" name="phonenumber" placeholder="Telefoonnummer"><br><br>

                <input type="text" name="subject" placeholder="Onderwerp*"><br><br>
            <div class="message">
                <textarea name="message" placeholder="Bericht*" required></textarea><br><br>
            </div>
                <div class="submit">
                    <button name="submit" type="submit" value="verzend">Verzend</button>
                </div>
            </form>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $firstname = $_POST["firstname"];
                $middlename = $_POST["middlename"];
                $lastname = $_POST["lastname"];
                $email = $_POST["email"];
                $phonenumber = $_POST["phonenumber"];
                $subject = $_POST["subject"];
                $message = $_POST["message"];

                $sql = "INSERT INTO contact (firstname, middlename, lastname, email, phonenumber, subject, message) VALUES (:firstname, :middlename, :lastname, :email, :phonenumber, :subject, :message)";
                $stm = $conn->prepare($sql);
                $stm->execute(array(
                    ':firstname' => $firstname,
                    ':middlename' => $middlename,
                    ':lastname' => $lastname,
                    ':email' => $email,
                    ':phonenumber' => $phonenumber,
                    ':subject' => $subject,
                    ':message' => $message,
                ));
                echo "<div class='sent'>";
                echo("Bedankt voor uw bericht! We proberen zo spoedig mogelijk te reageren.");
                echo "</div>";
            }

            ?>
        </div>


        <div class="contact-info">
            <div class="info-block">
                <h3>Adres</h3>
                <div class="address">
                    <p>Bloemstraat 22<br>
                        8081 CW, Elburg<br>
                        <a href="tel:+31525842787">0525-842787</a><br>
                        <a href="mailto:info@deplantage-elburg.nl">info@deplantage-elburg.nl</a>
                    </p>
                </div>
            </div>
            <div class="info-block">
                <h3>Openingstijden</h3>
                <div class="opening-hours">
                    <div class="left">
                        <p>
                            Maandag<br>
                            Dinsdag<br>
                            Woensdag<br>
                            Donderdag<br>
                            Vrijdag<br>
                            Zaterdag<br>
                            Zondag
                        </p>
                    </div>
                    <div class="right">
                        <p>
                            gesloten<br>
                            9:30 - 18:00<br>
                            9:30 - 18:00<br>
                            9:30 - 18:00<br>
                            9:30 - 21:00<br>
                            9:30 - 18:00<br>
                            gesloten
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="map">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4863.557958747252!2d5.830475341833164!3d52.44691842078629!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c7d3c35c46122d%3A0x8d4fc3dadcc18fba!2sDe+Plantage!5e0!3m2!1snl!2snl!4v1510852179639" width="100%" height="500" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

<?php include('footer.php'); ?>

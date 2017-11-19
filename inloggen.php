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
                    <button name="submit" type="submit" value="verzend">Verzend</button>
                </div>
            </form>

        </div>

        <div class="register">
            <div class="headertext">
                <h2>Register</h2>
            </div>

            <form method="post">
                <input type="text" name="firstname" placeholder="Naam*" required><br><br>

                <input type="text" name="middlename" placeholder="Tussenvoegsel"><br><br>

                <input type="text" name="lastname" placeholder="Achternaam*" required><br><br>

                <input type="email" name="email" placeholder="E-mail*" required><br><br>

                <input type="text" name="phonenumber" placeholder="Telefoonnummer"><br><br>

                <input type="text" name="address" placeholder="Straat + Huisnummer*"><br><br>

                <input type="text" name="city" placeholder="Woonplaats*"><br><br>

                <input type="text" name="postalcode" placeholder="Postcode*"><br><br>

                <input type="password" name="password" placeholder="Wachtwoord*"><br><br>

                <div class="loginsubmit">
                    <button name="submit" type="submit" value="verzend">Verzend</button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>

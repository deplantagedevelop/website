<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $user = new User($conn);
    $message = '';

    function editAccount($firstname, $middlename, $lastname, $email, $phonenumber, $address, $city, $postalcode, $roleid)
    {
        global $conn, $id;
        try {
            $stmt = $conn->prepare("UPDATE customer SET firstname = :firstname, middlename = :middlename, lastname = :lastname, email = :email, phonenumber = :phonenumber, address = :address, city = :city, postalcode = :postalcode, RoleID = :roleid WHERE ID = " . $id);

            $stmt->bindparam(":firstname", $firstname);
            $stmt->bindparam(":middlename", $middlename);
            $stmt->bindparam(":lastname", $lastname);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":phonenumber", $phonenumber);
            $stmt->bindparam(":address", $address);
            $stmt->bindparam(":city", $city);
            $stmt->bindparam(":postalcode", $postalcode);
            $stmt->bindparam(":roleid", $roleid);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    $roles = $conn->prepare("SELECT * FROM roles");
    $roles->execute();
    $role = $roles->fetchAll();
    $roles = NULL;
    function customer($conn, $id)
    {
        $customers = $conn->prepare("SELECT c.ID, firstname, middlename, lastname, email, phonenumber, address, city, postalcode, RoleID, r.ID name FROM customer AS c INNER JOIN roles AS r ON c.RoleID=r.ID WHERE c.ID =" . $id);
        $customers->execute();
        $customer = $customers->fetchAll();
        $customers = NULL;
        return $customer;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $firstname = $_POST["firstname"];
        $middlename = $_POST["middlename"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $phonenumber = $_POST["phonenumber"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $postalcode = $_POST["postalcode"];
        $roleid = $_POST["role"];
        $customerrole = $_POST["role"];
        if (editAccount($firstname, $middlename, $lastname, $email, $phonenumber, $address, $city, $postalcode, $roleid) === true) {
            $message = 'Gebruiker is succesvol gewijzigd!';
        } else {
            $message = 'Gebruiker kon niet worden aangepast, controleer of alles goed is ingevuld!';
        }
    }
    if (isset($_POST['submit'])) {
        ?>
        <a href="/dashboard/role" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
        <?php
    } else {
        ?>
        <a href="/dashboard/role" class="back-btn"
           onclick="return confirm('Weet u zeker dat u het bewerken van het account wil annuleren?');"><i
                    class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
        <?php
    }
    $customer = customer($conn, $id);
    foreach ($customer

             as $item) {
        $customerrole = $item["RoleID"];
        ?>
        <div class="content">
            <div class="dashboard-left">
                <form method="post" enctype="multipart/form-data">
                    <label>Voornaam</label>
                    <input type="text" name="firstname" value="<?php echo $item["firstname"]; ?>" placeholder="Voornaam"
                           required>
                    <label>Tussenvoegsel</label>
                    <input type="text" name="middlename" value="<?php echo $item["middlename"]; ?>"
                           placeholder="Tussenvoegsel">
                    <label>Achternaam</label>
                    <input type="text" name="lastname" value="<?php echo $item["lastname"]; ?>" placeholder="Achternaam"
                           required>
                    <label>E-mail</label>
                    <input type="text" name="email" value="<?php echo $item["email"]; ?>" placeholder="E-mail"
                           required>
                    <label>Rol</label>
                    <select name="role">
                        <?php
                        foreach ($role as $rol) {
                            if ($customerrole == $rol["ID"]) {
                                ?>
                                <option value="<?php echo $rol["ID"]; ?>"
                                        selected><?php echo $rol["name"]; ?></option>
                                <?php
                            } else {
                                ?>
                                <option value="<?php echo $rol["ID"]; ?>"><?php echo $rol["name"]; ?></option>
                                <?php
                            }

                        }
                        ?>
                    </select>
                    <input type="submit" name="submit" value="wijzigen">
            </div>
            <div class="dashboard-right">
                <label>Telefoonnummer</label>
                <input type="text" name="phonenumber" value="<?php echo $item["phonenumber"]; ?>"
                       placeholder="Telefoonnummer">
                <label>Plaatsnaam</label>
                <input type="text" name="city" value="<?php echo $item["city"]; ?>"
                       placeholder="Plaatsnaam">
                <label>Postcode</label>
                <input type="text" name="postalcode" value="<?php echo $item["postalcode"]; ?>"
                       placeholder="Postcode"
                       required>
                <label>Adres</label>
                <input type="text" name="address" value="<?php echo $item["address"]; ?>"
                       placeholder="Straatnaam + nummer"
                       required>
                </form>
            </div>
        </div>

        <?php
        echo $message;
    }
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');?>
?>
<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/user.php');
$user = new User($conn);
if ($user->has_role("Administrator")) {
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $query = ' WHERE firstname LIKE "%' . $search . '%" OR lastname LIKE "%' . $search . '%" OR email LIKE "%' . $search . '%" OR postalcode LIKE "%' . $search . '%" OR r.name LIKE "%' . $search . '%"';
    } else {
        $search = '';
        $query = '';
    }
    $customers = $conn->prepare("SELECT c.ID, firstname, middlename, lastname, email, phonenumber, address, city, postalcode, password, name, r.name FROM customer AS c INNER JOIN roles AS r ON c.RoleID=r.ID" . $query . " ORDER BY lastname");
    $customers->execute();
    $customer = $customers->fetchAll();
    $customers = NULL;
    ?>
    <div class="right-filter">
        <span>Zoek:</span>
        <form method="get" class="search-form">
            <input type="text" name="search" class="search" value="<?php echo $search; ?>" placeholder="zoeken">
        </form>
        <br>
    </div>
    <table class="dash-table role">
        <thead>
        <tr>
            <th class="rolefirstname">Voornaam</th>
            <th class="rolemiddlename">Tussenvoegsel</th>
            <th class="rolelastname">Achternaam</th>
            <th class="roleemail">Email</th>
            <th class="rolepostalcode">Postcode</th>
            <th class="roleedit">Bewerk</th>
            <th class="roledelete">Verwijder</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($customer as $item) {
            ?>
            <tr onclick="window.location='/dashboard/role/update?id=<?php echo $item["ID"]; ?>'">
                <td class="rolefirstname"><?php echo $item['firstname']; ?></td>
                <td class="rolemiddlename"><?php echo $item['middlename']; ?></td>
                <td class="rolelastname"><?php echo $item['lastname']; ?></td>
                <td class="roleemail"><?php echo $item['email']; ?></td>
                <td class="rolepostalcode"><?php echo $item['postalcode']; ?></td>
                <td class="roleedit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i><a
                            href="/dashboard/role/update?id=<?php echo $item['ID']; ?>">Bewerk</a></td>
                <td class="roledelete"><i class="fa fa-trash-o" aria-hidden="true"></i><a
                            href="/dashboard/role/delete?id=<?php echo $item['ID']; ?>"
                            onclick="return confirm('Weet u zeker dat u het account wil verwijderen?');">Verwijder</a>
                </td>
            </tr>

            <?php
        }
        ?>
        </tbody>
    </table>
    <a href="/dashboard/role/create" class="create-btn">Account toevoegen</a>
    <?php
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');?>

<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/user.php');
$user = new User($conn);

//Check for page request
$limit = 20;
if(empty($_GET['pagina'])) {
    $currentRow = 0;
    $_GET['pagina'] = 0;
} else {
    $pagina = $_GET['pagina'];
    $currentRow = ($pagina - 1) * $limit;
}

if ($user->has_role("Administrator")) {
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $paginationsearch = '&search=' . $search;
        $query = ' WHERE firstname LIKE "%' . $search . '%" OR lastname LIKE "%' . $search . '%" OR email LIKE "%' . $search . '%" OR postalcode LIKE "%' . $search . '%" OR r.name LIKE "%' . $search . '%"';
    } else {
        $search = '';
        $query = '';
        $paginationsearch = '';
    }
    $customers = $conn->prepare("SELECT c.ID, firstname, middlename, lastname, email, phonenumber, address, city, postalcode, password, name FROM customer AS c INNER JOIN roles AS r ON c.RoleID=r.ID" . $query . " ORDER BY lastname");
    $customers->execute();
    $customer = $customers->fetchAll();
    $customers = NULL;

    $rowCounts = $conn->prepare("SELECT COUNT(*) AS amount FROM customer AS c INNER JOIN roles AS r ON c.RoleID = r.ID " . $query);
    $rowCounts->execute();
    $rowCount = $rowCounts->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($rowCount['amount'] / $limit);
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
                            onclick="return confirm('Weet u zeker dat u het account wil verwijderen?');"> Verwijder</a>
                </td>
            </tr>

            <?php
        }
        ?>
        </tbody>
    </table>
    <div class="flex-pagination">
        <?php
            //Reset category Get because of products, only check for get in URL now.
            if (isset($_GET['categorie'])) {
                $category = $_GET['categorie'];
            } else {
                $category = '';
            }
            if ($_GET['pagina']) {
                $current = $_GET['pagina'];
                if ($current != 1) {
                    echo '<a href="/dashboard/role' . $paginationsearch . '"> << </a>';
                    echo '<a href="?pagina=' . ($current - 1) . $paginationsearch . '"> < </a>';
                }
            } else {
                $current = 1;
            }

            for ($i = $current; $i <= $current + 2; $i++) {
                if ($_GET['pagina'] == $i) {
                    echo '<a href="?pagina=' . $i . $paginationsearch . '" class="current">' . $i . '</a>';
                } elseif (empty($_GET['pagina']) && $i === 1) {
                    echo '<a href="?pagina=' . $i . $paginationsearch . '" class="current">' . $i . '</a>';
                } else {
                    if ($current != $total_pages) {
                        if ($current != $total_pages - 1) {
                            echo '<a href="?pagina=' . $i . $paginationsearch . '">' . $i . '</a>';
                        }
                    }
                }
            }
            if ($_GET['pagina'] != $total_pages) {
                if ($current <= $total_pages - 3) {
                    echo '<a href="#">...</a>';
                    echo '<a href="?pagina=' . $total_pages . $paginationsearch . '">' . $total_pages . '</a>';
                }
                if ($current == $total_pages - 1) {
                    echo '<a href="?pagina=' . $total_pages . $paginationsearch . '">' . $total_pages . '</a>';
                }
                if ($current != $total_pages) {
                    echo '<a href="?pagina=' . ($current + 1) . $paginationsearch . '"> > </a>';
                    echo '<a href="?pagina=' . $total_pages . '"> >> </a>';
                }
            }
        ?>
    </div>
    <a href="/dashboard/role/create" class="create-btn">Account toevoegen</a>
    <?php
}

include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');?>

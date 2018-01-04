<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');
    $user = new User($conn);
    $product = new Product($conn);

    $contact = $conn->prepare('SELECT * FROM contact ORDER BY date DESC');
    $contact -> execute();
    if ($contact->rowCount() > 0) {
        ?>
        <table class="dash-table">
            <thead>
            <tr>
                <th>Onderwerp</th>
                <th>Naam</th>
                <th>Datum</th>
                <th>Bekijken</th>
                <th>Verwijderen</th>
            </tr>
            </thead>
            <tbody>
            <?php
                foreach ($contact as $formulier) {
                    ?>
                    <tr>
                        <td><?php echo $formulier['subject']; ?></td>
                        <td><?php echo $formulier['firstname'] . " " . $formulier['middlename'] . " " .
                                $formulier['lastname']; ?></td>
                        <td><?php echo $formulier['date'] ?></td>
                        <td><i class="fa fa-eye" aria-hidden="true"></i></i> <a
                                    href="/dashboard/contact/view/<?php echo $formulier["ID"]; ?>">Bekijk</a></td>
                        <td><i class="fa fa-trash-o" aria-hidden="true"></i> <a
                                    href="/dashboard/contact/delete?id=<?php echo $formulier['ID']; ?>"
                                    onclick="return confirm('Weet u zeker dat u het contactformulier wil verwijderen?');">Verwijder</a>
                        </td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>

        <?php
    } else {
        echo 'Er zijn nog geen inzendingen verstuurd.';
    }
include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');


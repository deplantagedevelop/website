<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/slide.php');
    $user = new User($conn);
    $slide = new Slide($conn);

    $slides = $slide->getSlides();
?>
    <div class="content">
        <?php
            if ($slides->rowCount() > 0) {
                ?>
                <table class="dash-table">
                    <thead>
                    <tr>
                        <th>Slide</th>
                        <th>Slidertekst</th>
                        <th>Bewerk</th>
                        <th>Verwijder</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 0;
                        foreach ($slides as $item) {
                            $i++;
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $item['title']; ?></td>
                                <td><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <a
                                        href="/dashboard/slider/edit?id=<?php echo $item['ID']; ?>">Bewerk</a></td>
                                <td><i class="fa fa-trash-o" aria-hidden="true"></i> <a onclick="return confirm('Weet u zeker dat u het product wil verwijderen?')"
                                        href="/dashboard/slider/delete?id=<?php echo $item['ID']; ?>">Verwijder</a></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
                <?php
            } else {
                echo 'Geen slides gevonden<br>';
            }
        ?>
    </div>
    <a href="/dashboard/slider/create" class="create-btn">Slide toevoegen</a>

<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');


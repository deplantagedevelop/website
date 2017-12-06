<?php
    include ("../header.php");
    $url = "/";
    $id = $_GET["id"];

    $monthlyproduct = $conn->prepare("SELECT * FROM monthly_product WHERE ID= :id");
    $monthlyproduct->execute(array(
    ':id' => $id));

    while ($row = $monthlyproduct->fetch()) {
        $title = $row["title"];
        $description = $row["description"];
        $image = $row["image"];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $update_monthlyproduct = $conn->prepare("UPDATE monthly_product SET title=:title, description=:description WHERE id=:id");
        $update_monthlyproduct->execute(array(
            ':title' => $_POST["title"],
            ':description' => $_POST["description"],
            ':id' => $id
        ));
    }
?>

<form class="update-monthlyproduct" method="post" enctype="multipart/form-data">
    <img src="/assets/images/<?php echo $image ?>"> <br>
    <input type="file" name="image" id="image"><br> <br>
    Titel: <br>
    <input type="text" name="title" value="<?php echo "$title";?>"> <br> <br>
    Beschrijving: <br>
    <textarea name="description"><?php echo "$description";?></textarea> <br>
    <input type="submit" name="submit" value="submit">
</form>

<?php
    echo $image;
?>

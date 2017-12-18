<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/slide.php');
    $user = new User($conn);
    $slide = new Slide($conn);

?>
    <a href="/dashboard/slider" class="back-btn"><i class="fa fa-arrow-left" aria-hidden="true"></i>&nbsp; Terug</a>
    <div class="content">
        <div class="dashboard-left">
            <form method="post" enctype="multipart/form-data">
                <label>Slide tekst</label>
                <input type="text" name="title" placeholder="Slider tekst" required>
                <label>Slide afbeelding</label>
                <input type="file" name="image" id="image" onchange="readURL(this);" required>
                <input type="submit" value="Toevoegen">
            </form>
        </div>
        <div class="dashboard-right">
            <img id="product-image">
        </div>
    </div>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $image = uniqid() . "-" . $_FILES['image']['name'];
        $imagefile = $_FILES['image'];

        $slide->createSlide($title, $image, $imagefile);
    }


    include($_SERVER['DOCUMENT_ROOT'] . '/dashboard/footer.php');
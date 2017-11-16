<?php
include('lib/connection.php');

$statement = "SELECT title, description FROM news";
$result = $conn->query($statement);
?>
<html>
<head>
    <title>De Plantage</title>

    <link rel="stylesheet" type="text/css" href="/assets/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <script src="/assets/js/jquery-3.2.1.min.js"></script>
    <script src="/assets/js/main.js"></script>
</head>
<body>
<table>
    <?php
        foreach($result->fetchAll() as $result) {
            echo "<tr><td>". $result["title"] ."</td></tr>";
        }
    ?>
</table>
</body>
</html>
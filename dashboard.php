<?php
include('lib/connection.php');
include('functions/queries.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$countUsers = $conn->prepare("select count(*) from customer");
$countContact = $conn->prepare("select count(*) from contact");
$countProducten = $conn->prepare("select count(*) from products");
$countNews = $conn->prepare("select count(*) from news");
$countReviews = $conn->prepare("select count(*) from reviews");
?>
<!DOCTYPE HTML>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <title>De Plantage</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/dashboard.css">
    <script src="https://use.fontawesome.com/be669cc78c.js"></script>
</head>
<body>
<div class="dashcontent">
    <div class="dashleft">
        <div class="logo">
            <a href="/"><img src="/assets/images/dashlogo.png"></a>
        </div>
        <div class="dashmenu">
            <ul>
                <li><i class="fa fa-home" aria-hidden="true"></i><a href="/">&nbsp Home</a></li>
                <li><i class="fa fa-shopping-basket" aria-hidden="true"></i><a href="/nieuws">&nbsp Bestellingen</a></li>
                <li><i class="fa fa-users" aria-hidden="true"></i></i><a href="/shop">&nbsp Accounts</a></li>
                <li><i class="fa fa-shopping-bag" aria-hidden="true"></i><a href="/over-ons">&nbsp Producten</a></li>
                <li><i class="fa fa-newspaper-o" aria-hidden="true"></i><a href="/reviews">&nbsp Nieuws</a></li>
                <li><i class="fa fa-star" aria-hidden="true"></i><a href="/contact">&nbsp Reviews</a></li>
                <li><i class="fa fa-pencil-square-o" aria-hidden="true"></i><a href="/over-ons">&nbsp Contact</a></li>
                <li><i class="fa fa-info-circle" aria-hidden="true"></i><a href="/reviews">&nbsp Over ons</a></li>
                <li><i class="fa fa-coffee" aria-hidden="true"></i><a href="/contact">&nbsp Product van de maand</a></li>
                <li><i class="fa fa-cog" aria-hidden="true"></i><a href="/contact">&nbsp Overige instellingen</a></li>
            </ul>
        </div>
    </div>
    <div class="dashright">
        <div class="dashrightupper">
            <a>DASHBOARD</a>
        </div>
        <div class="dashrightunder">

            <div class="dashheader">
                <a>Dashboard</a>

            </div>

            <div class="dashblocksupper">
                <div class="dashblock dashbestelling green">
                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                    <a>20</a>
                    <div class="dashblocktitle">
                        <h2>Bestellingen</h2>
                    </div>
                </div>

                <div class="dashblock dashbestelling blue">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    <?php
                        $countUsers->execute();
                        while ($row = $countUsers ->fetch()) {
                            $hoeveelheidUsers = $row["count(*)"];
                        }
                        echo "<a> $hoeveelheidUsers </a>";
                    ?>
                    <div class="dashblocktitle">
                        <h2>Accounts</h2>
                    </div>
                </div>

                <div class="dashblock dashbestelling">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    <?php
                    $countContact->execute();
                        while ($row = $countContact ->fetch()) {
                            $hoeveelheidContact = $row["count(*)"];
                        }
                        echo "<a> $hoeveelheidContact </a>";
                    ?>
                    <div class="dashblocktitle">
                        <h2>Contactformulieren</h2>
                    </div>
                </div>
            </div>
            <div class="dashblocksunder">
                <div class="dashblock dashbestelling">
                    <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                    <?php
                    $countProducten->execute();
                    while ($row = $countProducten ->fetch()) {
                        $hoeveelheidProducten = $row["count(*)"];
                    }
                    echo "<a> $hoeveelheidProducten </a>";
                    ?>
                    <div class="dashblocktitle">
                        <h2>Producten</h2>
                    </div>
                </div>

                <div class="dashblock dashbestelling">
                    <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                    <?php
                    $countNews->execute();
                    while ($row = $countNews ->fetch()) {
                        $hoeveelheidNieuws = $row["count(*)"];
                    }
                    echo "<a> $hoeveelheidNieuws </a>";
                    ?>
                    <div class="dashblocktitle">
                        <h2>Nieuwsartikelen</h2>
                    </div>
                </div>

                <div class="dashblock dashbestelling">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <?php
                    $countReviews->execute();
                    while ($row = $countReviews ->fetch()) {
                        $hoeveelheidReviews = $row["count(*)"];
                    }
                    echo "<a> $hoeveelheidReviews </a>";
                    ?>
                    <div class="dashblocktitle">
                        <h2>Reviews</h2>
                    </div>
                </div>
            </div>





            </div>


        </div>

    </div>

</div>
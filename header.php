<?php
    include('lib/connection.php');
    include('functions/queries.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
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
    <link rel="stylesheet" type="text/css" href="/assets/css/slicknav.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/slick.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/reviews.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/contact.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/shop.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/overons.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/inloggen.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/news.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/newsitems.css"
</head>
<body>
<section class="header">
    <div class="top-header">
        <div class="inner-header">
            <div class="account">
                <a href="/inloggen">Inloggen</a>
            </div>
        </div>

    </div>
    <div class="main-header">
        <div class="header-left">
            <div class="logo">
                <a href="/"><img src="/assets/images/logo.png"></a>
            </div>
        </div>
        <div class="header-right">
            <div class="nav-bar">
                <ul id="menu">
                    <li><a href="/">Home</a></li>
                    <li><a href="/nieuws">Nieuws</a></li>
                    <li><a href="/shop">Producten</a></li>
                    <li><a href="/over-ons">Over ons</a></li>
                    <li><a href="/reviews">Reviews</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>
            <div class="header-mobile"></div>
        </div>
    </div>
</section>
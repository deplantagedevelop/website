<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    $url = "/";
    $id = $_GET["id"];
    $review = $conn->prepare("SELECT * FROM reviews WHERE id=:id");

    $review->execute(array(
        ':id' => $id
    ));
    echo "<a href=\"/dashboard/reviews/\"> Ga terug</a> <br>";
    while ($row = $review->fetch()) {
        $firstname = $row["firstname"];
        $middlename = $row["middlename"];
        $lastname = $row["lastname"];
        $date = $row["date"];
        $anonymous = $row["anonymous"];
        $rating = $row["rating"];
        $message = $row["message"];
        $reaction = $row["reaction"];
        echo "<p class='reviewInfo'>Naam:</p>";
        if ($anonymous == 1) {
            echo "<p class='reviewText'> Anoniem </p>";
        } else {
            echo "<p class='reviewText'> $firstname $middlename $lastname </p> ";
        }
              echo "<p class='reviewInfo'> Datum: </p>
              <p class='reviewText'> $date </p>";
              echo "<p class='reviewInfo'> Aantal sterren:<p> <p>";
              for ($i = 0; $i < $rating; $i ++) {
                    echo "<i class=\"starsrating fa fa-star fa-2x\" aria-hidden=\"true\"></i>";
              }
              echo "<p class='reviewInfo'>Toelichting:</p>
                    <p class='review-text'>$message<p> ";
              echo "<p class='reviewInfo'> Reactie: </p>";
              if (empty($reaction)) {
                  echo "<p class='review-text'> Geen reactie </p>";
              } else {
                  echo "<p class='review-text'> $reaction </p>";
              }
    }
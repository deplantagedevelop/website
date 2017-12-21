<?php
    include_once($_SERVER['DOCUMENT_ROOT'] . '/dashboard/header.php');
    include_once($_SERVER['DOCUMENT_ROOT'] . '/functions/products.php');

    if(isset($_GET["id"])) {
        $id = $_GET["id"];

        $status = $conn->prepare("UPDATE orders SET status='afgerond' WHERE ID=:id");
        $status->execute(array(
            ":id" => $id
        ));

        $order = $conn->prepare("SELECT CustomerID FROM orders WHERE ID = :id");
        $order->execute(array(
            ":id" => $id
        ));
        $customerID = $order->fetch(PDO::FETCH_ASSOC);

        $customer = $conn->prepare("SELECT * FROM customer WHERE ID = :id");
        $customer->execute(array(
            ":id" => $customerID['CustomerID']
        ));

        foreach ($customer as $item) {
            $subjectklant = 'Uw bestelling staat klaar!';
            $messageklant = 'Beste ' . $item['firstname'] . ', <br><br>
                                                    Uw bestelling met het ordernummer: ' . $id . ' staat klaar in onze winkel en die kunt u vanaf nu afhalen.<br>
                                                    Klik <a href="' . "http://" . $_SERVER['SERVER_NAME'] . '/vieworder?id=' . $id . '">hier</a> om uw bestelling te bekijken.<br><br><br>
                                                    de Plantage<br>
                                                    Bloemstraat 22<br>
                                                    8081 CW, Elburg<br>
                                                    0525-842787<br>
                                                    info@deplantage-elburg.nl<br><br>
                                                    <img width="250" src="https://plantagedevelopment.nl/assets/images/logo.png" alt="de Plantage"><br>';
            $headers[] = 'From: de Plantage Elburg <no-reply@plantagedevelopment.nl>' . "\r\n" .
                'Reply-To: info@plantagedevelopment.nl' . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';

            mail($item['email'], $subjectklant, $messageklant, implode("\r\n", $headers));
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
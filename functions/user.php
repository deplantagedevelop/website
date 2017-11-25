<?php
class User
{
    private $db;

    function __construct($conn)
    {
        $this->db = $conn;
    }

    public function register($firstname, $middlename, $lastname, $phonenumber, $address, $city, $postalcode, $email, $password){
        try {
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("INSERT INTO users(firstname, middlename, lastname, email, phonenumber, address, city, postalcode, password) 
                                                       VALUES(:firstname, :middlename, :lastname, :email, :phonenumber, :address, :city, :postalcode :password)");

            $stmt->bindparam(":firstname", $firstname);
            $stmt->bindparam(":middlename", $middlename);
            $stmt->bindparam(":lastname", $lastname);
            $stmt->bindparam(":phonenumber", $phonenumber);
            $stmt->bindparam(":address", $address);
            $stmt->bindparam(":city", $city);
            $stmt->bindparam(":postalcode", $postalcode);
            $stmt->bindparam(":email", $email);
            $stmt->bindparam(":password", $hashed_pass);
            $stmt->execute();

            return $stmt;
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function login($email, $password) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM customer WHERE email = :email LIMIT 1");
            $stmt->execute(array(':email' => $email));
            $userRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() > 0) {
                if(password_verify($password, $userRow['password'])) {
                    $_SESSION['user_session'] = $userRow['ID'];
                    return true;
                } else {
                    return false;
                }
            }
        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function is_loggedin() {
        if(isset($_SESSION['user_session'])) {
            return true;
        }
    }

    public function redirect($url) {
        header("Location: $url");
    }

    public function logout() {
        session_destroy();
        unset($_SESSION['user_session']);
        return true;
    }
}

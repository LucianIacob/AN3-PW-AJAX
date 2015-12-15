<?php
/**
 * Created by PhpStorm.
 * User: Lucian
 * Date: 12.12.2015
 * Time: 23:03
 */

$usr = $_POST["username"];
$ocupatia = $_POST["ocupatia"];
$varsta = $_POST["varsta"];
$email = $_POST["email"];

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "pw_users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "UPDATE biblio SET ocupatia = ?, varsta = ?, email = ? WHERE username = ?;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $ocupatia, $varsta, $email, $usr);
$stmt->execute();

$stmt->close();
$conn->close();

?>
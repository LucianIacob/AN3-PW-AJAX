<?php
/**
 * Created by PhpStorm.
 * User: Lucian
 * Date: 12.12.2015
 * Time: 15:53
 */

$usr = $_GET["username"];

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "pw_users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT ocupatia, varsta, email FROM biblio WHERE username = ?;";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usr);
$stmt->execute();
$stmt->bind_result($ocupatia, $varsta, $email);

$users = array();

while ($stmt->fetch()) {
    $user = new StdClass();
    $user->ocupatia = $ocupatia;
    $user->varsta = $varsta;
    $user->email = $email;
    $user->username = $usr;

    array_push($users, $user);
}

echo json_encode($users);

$stmt->close();
$conn->close();

?>
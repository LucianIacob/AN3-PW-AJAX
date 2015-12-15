<?php
/**
 * Created by PhpStorm.
 * User: Lucian
 * Date: 12.12.2015
 * Time: 15:03
 */

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "pw_users";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username FROM biblio;";

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($usrname);

$users = array();

while ($stmt->fetch()) {
    $user = new StdClass();
    $user->username = $usrname;

    array_push($users, $user);
}

echo json_encode($users);

$stmt->close();
$conn->close();

?>
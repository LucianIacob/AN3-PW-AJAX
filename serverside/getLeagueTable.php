<?php
/**
 * Created by PhpStorm.
 * User: Lucian
 * Date: 13.12.2015
 * Time: 12:06
 */

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "premierleague";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM premierleague order by points desc, wins desc;";

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->bind_result($points, $club, $wins, $drawn, $loss, $GF, $GA, $played);

$teams = array();

while ($stmt->fetch()) {
    $team = new StdClass();
    $team->club = $club;
    $team->wins = $wins;
    $team->drawn = $drawn;
    $team->loss = $loss;
    $team->GF = $GF;
    $team->GA = $GA;
    $team->played = $played;
    $team->points = $points;

    array_push($teams, $team);
}

echo json_encode($teams);

$stmt->close();
$conn->close();

?>
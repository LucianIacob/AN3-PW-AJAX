<?php
/**
 * Created by PhpStorm.
 * User: Lucian
 * Date: 13.12.2015
 * Time: 16:33
 */
$teams = json_decode(stripslashes($_GET['teams']));
$scores = json_decode(stripslashes($_GET['scores']));

for ($i = 0; $i <= 16; $i = $i + 2) {
    if ($scores[$i] == $scores[$i + 1]) {
        resolveDrawn($teams[$i], $scores[$i], $teams[$i + 1]);
    } else if ($scores[$i] > $scores[$i + 1]) {
        resolveWin($teams[$i], $scores[$i], $scores[$i + 1], $teams[$i + 1]);
    } else {
        resolveWin($teams[$i + 1], $scores[$i + 1], $scores[$i], $teams[$i]);
    }
}

function resolveDrawn($team1, $goals, $team2)
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "premierleague";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE premierleague.premierleague SET played=played+1, draws=draws+1, goals_for=goals_for+" . $goals . ", goals_against=goals_against+" . $goals . ", points=points+1 WHERE club='" . $team1 . "';";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating record: " . $conn->error;
    }

    $sql = "UPDATE premierleague.premierleague SET played=played+1, draws=draws+1, goals_for=goals_for+" . $goals . ", goals_against=goals_against+" . $goals . ", points=points+1 WHERE club='" . $team2 . "';";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}

function resolveWin($winner, $scoreWinner, $scoreLooser, $looser)
{
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "premierleague";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "UPDATE premierleague.premierleague SET played=played+1, wins=wins+1, goals_for=goals_for+" . $scoreWinner . ", goals_against=goals_against+" . $scoreLooser . ", points=points+3 WHERE club='" . $winner . "';";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating record: " . $conn->error;
    }

    $sql = "UPDATE premierleague.premierleague SET played=played+1, loses=loses+1, goals_for=goals_for+" . $scoreLooser . ", goals_against=goals_against+" . $scoreWinner . " WHERE club='" . $looser . "';";
    if ($conn->query($sql) !== TRUE) {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
}
<?php

require_once("vendor/autoload.php");

use Football\Uefa\Player as Player;
use Football\Uefa\Team as Team;
use Football\Uefa\Game as Game;
use Football\Uefa\Match as Match;

/**
 * for development
 */
error_reporting(E_ALL);
ini_set("display_startup_errors", "1");
ini_set("display_errors", "1");

/**
 * simulate front-end
 * create 4 teams for uefa group
 * add players to team
 * build formation and start game
 */
$team1 = new Team\Team("Partizan");
$team2 = new Team\Team("Manchester");
$team3 = new Team\Team("AZ Alkmaar");
$team4 = new Team\Team("Astana");

/**
 * 22 players in total: 2 goalies, 6 defenders, 10 midfielders and 4 strikers
 */
$players = [];

$players["G"][] = new Player\Player("goalie", 5, 5);
$players["G"][] = new Player\Player("goalie", 4, 3);

$players["D"][] = new Player\Player("defender", 5, 5);
$players["D"][] = new Player\Player("defender", 5, 5);
$players["D"][] = new Player\Player("defender", 4, 3);
$players["D"][] = new Player\Player("defender", 3, 4);
$players["D"][] = new Player\Player("defender", 2, 2);
$players["D"][] = new Player\Player("defender", 1, 3);

$players["M"][] = new Player\Player("midfielder", 4, 4);
$players["M"][] = new Player\Player("midfielder", 5, 3);
$players["M"][] = new Player\Player("midfielder", 3, 5);
$players["M"][] = new Player\Player("midfielder", 2, 5);
$players["M"][] = new Player\Player("midfielder", 5, 1);
$players["M"][] = new Player\Player("midfielder", 1, 3);
$players["M"][] = new Player\Player("midfielder", 1, 1);
$players["M"][] = new Player\Player("midfielder", 2, 4);
$players["M"][] = new Player\Player("midfielder", 5, 5);
$players["M"][] = new Player\Player("midfielder", 4, 5);

$players["S"][] = new Player\Player("striker", 5, 4);
$players["S"][] = new Player\Player("striker", 4, 4);
$players["S"][] = new Player\Player("striker", 3, 3);
$players["S"][] = new Player\Player("striker", 2, 5);

$team1->addPlayers($players);

/**
 * formations - db sim
 */
$formations = [
    "defence" => "5-4-1",
    "regular" => "4-4-2",
    "attack" => "3-4-3",
];

/**
 * let's play
 */
$game1 = new Game\Game($team1, $team2);
$team1->setFormation("defence");
$teamMatch1 = $team1->teamForMatch($formations);
$result1 = $game1->simulateMatch();

$game2 = new Game\Game($team1, $team3);
$team1->setFormation("regular");
$teamMatch2 = $team1->teamForMatch($formations);
$result2 = $game2->simulateMatch();

$game3 = new Game\Game($team1, $team4);
$team1->setFormation("attack");
$teamMatch3 = $team1->teamForMatch($formations);
$result3 = $game3->simulateMatch();

/**
 * print
 */
echo $game1->getMatchInfo() . "<br>";
echo $game2->getMatchInfo() . "<br>";
echo $game3->getMatchInfo() . "<br><hr>";

echo $team1->listAllPlayers() . "<hr>";

/**
 * selected players for first match
 */
$playerList = [];

foreach ($teamMatch1 as $player) {
    $playerList[] = $player->printPlayerInfo();
}

$playerToStr = implode("<br>", $playerList);

echo $playerToStr . "<hr>";

/**
 * selected players for second match
 */
$playerList = [];

foreach ($teamMatch2 as $player) {
    $playerList[] = $player->printPlayerInfo();
}

$playerToStr = implode("<br>", $playerList);

echo $playerToStr . "<hr>";

/**
 * selected players for third match
 */
$playerList = [];

foreach ($teamMatch3 as $player) {
    $playerList[] = $player->printPlayerInfo();
}

$playerToStr = implode("<br>", $playerList);

echo $playerToStr . "<hr>";

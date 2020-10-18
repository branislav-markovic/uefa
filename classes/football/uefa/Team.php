<?php

namespace Football\Uefa\Team;

class Team
{
    private $name;
    private $players = null;
    private $formation = null;

    /**
     * Set team name
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Get team name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get all players
     * @return string
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * Set complete team - 22 players
     * 2 goalies, 6 defenders, 10 midfielders and 4 strikers
     * @param array $players
     */
    public function addPlayers($players)
    {
        $this->players = $players;
    }

    /**
     * Complete team - info about 22 players as string
     * @return string
     * @throws Exception If no players
     */
    public function listAllPlayers()
    {
        if (empty($this->players)) {
            throw new \Exception("Set players first");
        }

        $playerList = [];
        $i = 0;

        foreach ($this->players as $allPlayers) {
            foreach ($allPlayers as $player) {
                $i++;
                $playerList[] = $player->printPlayerInfo();
            }
        }

        $playerToStr = implode("<br>", $playerList);

        return $playerToStr;
    }

    /**
     * Assemble team for the match - depends on the opponent strength
     * Formation can be defence, regular, attack
     * @param array $formations
     * @return array
     * @throws Exception If formation not set
     */
    public function teamForMatch($formations)
    {
        if (empty($this->formation)) {
            throw new \Exception("Formation not set");
        }
        
        $formation = $formations[$this->formation];
        $gkeeps = $this->players["G"];
        $defend = $this->players["D"];
        $middle = $this->players["M"];
        $attack = $this->players["S"];
        shuffle($gkeeps);
        $team = [];
        
        switch ($this->formation) {
            case "defence":
                $strikers = $this->sortPlayers($attack, "speed");
                $mids = $this->sortPlayers($middle, "quality");
                $defs = $this->sortPlayers($defend, "quality");

                $team[0] = array_slice($defs, 0, 5, true);
                $team[1] = array_slice($mids, 0, 4, true);
                $team[2] = array_slice($strikers, 0, 1, true);
                $team = array_merge($team[0], $team[1], $team[2]);
                $team[] = $gkeeps[0];
                break;
            case "regular":
                $strikers = $this->sortPlayers($attack, "quality");
                $mids = $this->sortPlayers($middle, "quality");
                $defs = $this->sortPlayers($defend, "quality");

                $team[0] = array_slice($defs, 0, 4, true);
                $team[1] = array_slice($mids, 0, 4, true);
                $team[2] = array_slice($strikers, 0, 2, true);
                $team = array_merge($team[0], $team[1], $team[2]);
                $team[] = $gkeeps[0];
                break;
            case "attack":
                $strikers = $this->sortPlayers($attack, "quality");
                $mids = $this->sortPlayers($middle, "quality");
                $defs = $this->sortPlayers($defend, "quality");

                $team[0] = array_slice($defs, 0, 3, true);
                $team[1] = array_slice($mids, 0, 4, true);
                $team[2] = array_slice($strikers, 0, 3, true);
                $team = array_merge($team[0], $team[1], $team[2]);
                $team[] = $gkeeps[0];
                break;
        }

        return $team;
    }

    /**
     * @param string $type
     */
    public function setFormation($type)
    {
        $this->formation = $type;
    }

    /**
     * Sort players by speed or quality
     * @param array $players
     * @param string $prop
     * @return array
     */
    private function sortPlayers($players, $prop)
    {
        $method = "getSpeed";

        if ($prop == "quality") {
            $method = "getQuality";
        }

        usort($players, function($a, $b) use ($method) {
            return strcmp($b->{$method}(), $a->{$method}());
        });

        return $this->filterInjury($players);
    }

    /**
     * Remove injured players from array
     * @param array $players
     * @return array
     */
    private function filterInjury($players)
    {
        $players = array_filter($players, function($player) {
            return $player->getInjury() === false;
        });

        return $players;
    }
}

<?php

namespace Football\Uefa\Game;

class Game
{
    private $team1;
    private $team2;
    private $result;

    /**
     * @param object $team1
     * @param object $team2 
     */
    public function __construct($team1, $team2)
    {
        $this->team1 = $team1;
        $this->team2 = $team2;
        $this->result = null;
    }

    /**
     * Play match between two teams
     * Result is simulated with mt_rand
     * @return string
     */
    public function simulateMatch()
    {
        $home = mt_rand(0, 5);
        $away = mt_rand(0, 5);

        $playerPositions = ["D", "M", "S"];
        shuffle($playerPositions);
        $setPosition = $playerPositions[0];
        $players = $this->team1->getPlayers();
        $randomPlayer = $players[$setPosition][mt_rand(0, count($players[$setPosition]) - 1)]->setInjury(true);

        return ($this->result = $home . " : " . $away);
    }

    /**
     * Get match info - the name of teams and result
     * @return string
     * @throws Exception If the match not played
     */
    public function getMatchInfo()
    {
        if (empty($this->result)) {
            throw new \Exception("No results");
        }

        return $this->team1->getName() . " - " . $this->team2->getName() . " " . $this->result;
    }
}

<?php

namespace Football\Uefa\Player;

class Player
{
    private $position;
    private $quality;
    private $speed;
    private $injury;

    /**
     * @param string $position
     * @param int $quality
     * @param int $speed
     */
    public function __construct($position, $quality, $speed)
    {
        $this->position = $position;
        $this->quality = $quality;
        $this->speed = $speed;
        $this->injury = false;
    }

    /**
     * Player position - goalie, defender, midfielder and striker
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * From 1 - 5
     * @return int
     */
    public function getQuality()
    {
        return $this->quality;
    }

    /**
     * From 1 - 5
     * @return int
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @return bool $injury
     */
    public function getInjury()
    {
        return $this->injury;
    }

    /**
     * @param bool $injury
     */
    public function setInjury($injury)
    {
        $this->injury = $injury;
    }

    /**
     * Get player position, quality and speed as string
     * @return string
     */
    public function printPlayerInfo()
    {
        return "Position: {$this->getPosition()} | Quality: {$this->getQuality()} | Speed: {$this->getSpeed()}" . "<br>";
    }
}

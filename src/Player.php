<?php
/**
 * Created by PhpStorm.
 * User: Marcel
 */

/** Class Player*/
class Player
{
    /**
     * Name of the player
     * @var string $name
     */
    private $name;

    /**
     * TicTacToe symbol of the player
     * @var string $symbol
     */
    private $symbol;

    /**
     * Contains the count of wins for this player
     * @var int score
     */
    private $score = 0;

    /**
     * Player constructor.
     * @param $name
     * @param $symbol
     */
    public function __construct($name, $symbol) {
        $this->name = $name;
        $this->symbol = $symbol;
    }

    /**
     * Returns the name
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * Returns the name
     * @return string
     */
    public function getSymbol() {
        return $this->symbol;
    }

    /**
     * Returns the players score
     * @return int
     */
    public function getScore() {
        return $this->score;
    }

    /**
     * Increase the score by one
     */
    public function increaseScore() {
        $this->score++;
    }

}
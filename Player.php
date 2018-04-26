<?php

class Player
{
    /** @var string $name */
    private $name;

    /** @var string $symbol */
    private $symbol;

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

}
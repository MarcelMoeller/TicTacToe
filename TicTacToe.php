<?php

class TicTacToe
{
    /** @var \Board $board */
    private $board;

    /** @var \Player $playerOne */
    private $playerOne;

    /** @var \Player $playerTwo */
    private $playerTwo;

    /** @var \Player $currentPlayer */
    private $currentPlayer;

    /**
     * TicTacToe constructor.
     * @param Board $board
     * @param Player $playerOne
     * @param Player $playerTwo
     * @param Player $currentPlayer
     */
    public function __construct(Board $board, Player $playerOne, Player $playerTwo, Player $currentPlayer)
    {
        $this->board = $board;
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
        $this->currentPlayer = $currentPlayer;
    }

    /**
     * @param int $row
     * @param int $column
     * @param string $symbol
     * Play a turn
     */
    public function playTurn($row, $column, $symbol)
    {
        if($this->board->setPosition($row,$column,$symbol)) {
            $this->board->showBoard($this->currentPlayer);
            if($this->checkGameEnd()) {
                echo "There is a winner";
                session_destroy();
                //@ToDo Add game end
            }
            $this->switchPlayer();

        } else {
            $this->board->showBoard($this->currentPlayer);
        }
    }

    /**
     * @UMLCHANGES There is no method to switch players and it would be better to outsource it into its on method instead of writing it into the playTurn method
     */
    private function switchPlayer(){
        if($this->currentPlayer === $this->playerOne) {
            $this->currentPlayer = $this->playerTwo;
        } elseif ($this->currentPlayer === $this->playerTwo) {
            $this->currentPlayer = $this->playerOne;
        } else {
            echo "Spieler konnte nicht gewechselt werden";
        }
    }

    /**
     * @UMLCHANGES Rename getWinner() function and check the winner through currentPlayer
     *
     * @return bool
     */
    private function checkGameEnd()
    {
        $board = $this->board->getBoard();
        $checkDiaLeft = [];
        $checkDiaRight = [];
        // Iterate through each board row
        for ($iRow = 0; $iRow < count($board); $iRow++) {
            /** Check for winning row */
            $checkRow = $board[$iRow];


            /** Check for winning column*/
            $checkColumn = [];
            for ($iColumn = 0; $iColumn < count($board); $iColumn++) {
                $checkColumn[] = $board[$iColumn][$iRow];
            }

            /** Check for winning diagonal */
            $currDiaColumn = count($board) - 1 - $iRow;
            $checkDiaLeft[] = $board[$iRow][$currDiaColumn];
            $checkDiaRight[] = $board[$iRow][$iRow];
            if( $this->checkUnique($checkColumn) || $this->checkUnique($checkRow)) {
                return true;
            }
        }
        if( $this->checkUnique($checkDiaLeft) || $this->checkUnique($checkDiaRight)) {
            return true;
        }
        return false;
    }

    /**
     * @UMLCHANGES Added as an Helper function to prevent repeating
     *
     * Check for a single unique value which is not empty
     * @param $array
     * @return bool
     */
    private function checkUnique($array)
    {
        $array = array_unique($array);
        if (count($array) === 1 && !empty($array[0])) {
            return true;
        }
    }

    /**
     * Returns the board
     */
    public function showBoard() {
        $this->board->showBoard($this->currentPlayer);
    }

}
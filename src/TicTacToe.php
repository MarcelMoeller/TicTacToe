<?php
/**
 * Created by PhpStorm.
 * User: Marcel
 */

/**
 * Class TicTacToe
 */
class TicTacToe
{
    /**
     * Board object
     * @var \Board $board
     */
    private $board;

    /**
     * Player 1
     * @var \Player $playerOne
     */
    private $playerOne;

    /**
     * Player 2
     * @var \Player $playerTwo
     */
    private $playerTwo;

    /**
     * The current player
     * @var \Player $currentPlayer
     */
    private $currentPlayer;

    /**
     * It is used to check if the game resulted in a draw
     * @var bool $isDraw
     */
    private $isDraw;

    /**
     * TicTacToe constructor.
     * @param Board $board
     * @param Player $playerOne
     * @param Player $playerTwo
     * @param Player $currentPlayer
     */
    public function __construct(Board $board, Player $playerOne, Player $playerTwo, Player $currentPlayer)
    {
        //Assing parameter to TicTacToe properties
        $this->board = $board;
        $this->playerOne = $playerOne;
        $this->playerTwo = $playerTwo;
        $this->currentPlayer = $currentPlayer;
    }

    /**
     * Play a turn and change the player afterwards
     * @param int $row
     * @param int $column
     * @throws
     */
    public function playTurn($row, $column)
    {
        //Set a symbol with setPosition() and check if the method returns true
        //setPosition() method returns true if the symbol got successfully set at the specific position
        if($this->board->setPosition($row,$column,$this->currentPlayer->getSymbol())) {
            //Check if the game ends
            if($this->checkGameEnd()) {
                //Check if the game ended in a draw and output the specific notification
                if ($this->isDraw === true) {
                    \Notification::addOutput('This game resulted in a draw.');
                } else {
                    $this->currentPlayer->increaseScore();
                    \Notification::addOutput('The winner is ' . $this->currentPlayer->getName() . '');
                }
                //Clears the board to start a new game
                $this->board->resetBoard();
                //Reset isDraw to prevent all following games to end in a draw.
                $this->isDraw = false;

            }
            //Switch the player and show the current board after the current player played his turn
            $this->togglePlayer();
        }
    }

    /**
     * Toggles between the two players of the TicTacToe object
     */
    private function togglePlayer(){
        //Check if the currentPlayer is either playerOne or playerTwo and switch to the other one
        if($this->currentPlayer === $this->playerOne) {
            $this->currentPlayer = $this->playerTwo;
        } elseif ($this->currentPlayer === $this->playerTwo) {
            $this->currentPlayer = $this->playerOne;
        } else {
            \Notification::addOutput("Spieler konnte nicht gewechselt werden");
        }
    }

    /**
     * Check if the game ends and return a boolean
     *
     * @return bool
     */
    private function checkGameEnd()
    {
        $board = $this->board->getBoard();
        $gotEmptyField = false;
        $checkDiaLeft = [];
        $checkDiaRight = [];
        // Iterate through each board row
        for ($iRow = 0; $iRow < count($board); $iRow++) {
            /** Check for winning row */
            $checkRow = $board[$iRow];

            //Check the row for a empty field and set $gotEmptyField to true if there is one
            if(in_array("",$checkRow)) {
                $gotEmptyField = true;
            }

            //Assign the the current column to the checkColumn variable
            $checkColumn = [];
            for ($iColumn = 0; $iColumn < count($board); $iColumn++) {
                $checkColumn[] = $board[$iColumn][$iRow];
            }

            //Add the variable currDiaColumn to get a whole diagonal which starts at the bottom left and ends at the top right.
            //The "-1" is important cause the count function starts counting at 1 and $iRow starts at 0. That means that there would be one column to much
            $currDiaColumn = count($board) - $iRow  - 1;
            //Diagonal bottom left to top right
            $checkDiaRight[] = $board[$iRow][$currDiaColumn];
            //Diagonal top left to bottom right
            $checkDiaLeft[] = $board[$iRow][$iRow];
            //Check if the prepared column and row only got one unique symbol inside and no empty fields
            if( $this->checkUnique($checkColumn) || $this->checkUnique($checkRow)) {
                return true;
            }
        }
        //Check if the prepared diagonals only got one unique symbol inside and no empty fields
        if( $this->checkUnique($checkDiaLeft) || $this->checkUnique($checkDiaRight)) {
            return true;
        }

        //Set isDraw to true and return true if there is no empty field
        if($gotEmptyField === false) {
            $this->isDraw = true;
            return true;
        }
        //If none of the checks which would end the game return true, return false to continue the game.
        return false;
    }

    /**
     * Check for a single unique value which is not empty
     * @param $array
     * @return bool
     */
    private function checkUnique($array)
    {
        //Remove all elements which occure atleast twice in the array.
        $array = array_unique($array);
        //Check if the unique array got only one value and if this value is not empty
        if (count($array) === 1 && !empty($array[0])) {
            return true;
        }
    }

    /**
     * Call the showBoard method of the board
     * This way there is no need to somehow get the current player if the showBoard method of the board gets called outside the TicTacToe class
     */
    public function showBoard() {
        return $this->board->renderBoard($this->currentPlayer);
    }

    /**
     * Returns the current score of both players
     * @return string
     */
    public function showCurrentScore() {
        $output = "";
        $output .= '<div>';
        $output .= '<div>';
        $output .= '<p>' . $this->playerOne->getName() .'(' . $this->playerOne->getSymbol() .'): ' . $this->playerOne->getScore() .'</p>';
        $output .= '</div>';
        $output .= '<div>';
        $output .= '<p>' . $this->playerTwo->getName() .'(' . $this->playerTwo->getSymbol() .'): ' . $this->playerTwo->getScore() .'</p>';
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }

}
?>
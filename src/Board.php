<?php
/**
 * Created by PhpStorm.
 * User: Marcel
 */

/**
 * Board class
 */
class Board
{
    /**
     * TicTacToe board as an array
     * @var array $board
     */
    private $board = [
        ["", "", ""],
        ["", "", ""],
        ["", "", ""],
    ];

    /**
     * Returns the board
     * @return array $board
     */
    public function getBoard()
    {
        return $this->board;
    }


    /**
     * Renders the Board with the information from the $board array
     * @return string $boardHtml
     * @param \Player $currentPlayer
     */
    public function renderBoard($currentPlayer)
    {
        $boardHtml = "";
        $boardHtml .= '<table class="tic">';
        //Iterates through each row and generate each row
        for ($iRow = 0; $iRow < count($this->board); $iRow++) {
            $boardHtml .= '<tr>';
            for ($iColumn = 0; $iColumn < count($this->board[$iRow]); $iColumn++) {
                //Checks if the cell is empty
                if (empty($this->board[$iRow][$iColumn])) {
                    $boardHtml .= '<td><input type="submit"  class="reset field color'. $currentPlayer->getSymbol() .'" name="cell-' . $iRow . '-' . $iColumn . '" value="' . $currentPlayer->getSymbol() . '" /></td>';
                }
                //Checks if the cell has a "X"
                if ($this->board[$iRow][$iColumn] === "X") {
                    $boardHtml .= '<td><span class="colorX">X</span></td>';
                }
                //Checks if the cell has a "O"
                if ($this->board[$iRow][$iColumn] === "O") {
                    $boardHtml .= '<td><span class="colorO">O</span></td>';
                }
            }
            $boardHtml .= '</tr>';
        }
        $boardHtml .= '</table>';
        return $boardHtml;
    }

    /**
     * Sets a symbol at a specific cell
     * @param int $row
     * @param int $column
     * @param string $symbol The symbol needs to be the char O or X.
     * @return bool
     */
    public function setPosition($row,$column,$symbol){
        //Sets the symbol at the given position if it is empty and return true
        if (isset($this->board[$row][$column]) && empty($this->board[$row][$column])) {
            $this->board[$row][$column] = $symbol;
            return true;
        } else {
            //Outputs a notification and return false
            \Notification::addOutput("Field is already set or does not exist");
            return false;
        }
    }

    /**
     * Clears the board
     */
    public function resetBoard() {
        $this->board = [
            ["", "", ""],
            ["", "", ""],
            ["", "", ""],
        ];
    }
}
?>
<?php

class Board
{
    /** @var array $board */
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
     * @UMLCHANGES There is no way to render the boards html at all
     *
     * Outputs the board
     * @param \Player $currentPlayer
     */
    public function showBoard($currentPlayer)
    {
        $boardTemplate = "";
        //Gets the top part of the html document and add it to the template.
        $boardTemplate .= file_get_contents("BoardTemplateTop.php");
        //Call the renderBoard method which renders the board for the currentPlayer.
        $boardTemplate .= $this->renderBoard($currentPlayer);
        //Gets the bottom part of the html document and add it to the template.
        $boardTemplate .= file_get_contents("BoardTemplateBottom.php");
        //Output the html document.
        echo $boardTemplate;
    }


    /**
     * @UMLCHANGES There is no way to render the boards html at all
     *
     * Renders the Board with the information from the $board array
     * @return string $boardHtml
     * @param \Player $currentPlayer
     */
    public function renderBoard($currentPlayer)
    {
        $boardHtml = "";
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
            $boardHtml .= '<tr/>';
        }

        return $boardHtml;
    }

    /**
     * Sets a symbol at a specific cell
     * @param int $row
     * @param int $column
     * @param int $symbol
     * @return bool
     */
    public function setPosition($row,$column,$symbol){
        //Sets the symbol at the given position if it is empty and return true
        if (isset($this->board[$row][$column]) && empty($this->board[$row][$column])) {
            $this->board[$row][$column] = $symbol;
            return true;
        } else {
            //Outputs a notification and return false
            var_dump("Field is already set or does not exist");
            return false;
        }
    }
}

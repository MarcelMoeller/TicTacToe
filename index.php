<?php
    session_start();
    //Include classes
    require_once("TicTacToe.php");
    require_once("Player.php");
    require_once("Board.php");
    //Check if the $_SESSION variable contains the tictactoe object
    if(isset($_SESSION["Tictactoe"])){
        //Unserialize tictactoe variable
        $game = unserialize($_SESSION["Tictactoe"]);
        //Check if the $_GET variable is not empty
        if(!empty($_GET)){
            $key = key($_GET);
            $matches = [];
            preg_match("/cell-(\d)-(\d)/",$key,$matches);
            $row = $matches[1];
            $column = $matches[2];
            //Play a turn with the values of the $_GET variable
            $game->playTurn($row,$column,$_GET[$key]);
        } else {
            //If $_GET is empty just show the board
            $game->showBoard();
        }
    } else {
        //Create a new TicTacToe game including the board and the two players and show the empty board afterwards
        $board = new Board();
        $playerOne = new Player("Marcel","X");
        $playerTwo = new Player("Marcel2","O");
        /** @noinspection PhpUndefinedClassInspection */
        $game = new TicTacToe($board, $playerOne, $playerTwo, $playerOne);
        $game->showBoard();
    }

    //Safe the current TicTacToe game into a session
    $_SESSION["Tictactoe"] = serialize($game);

?>

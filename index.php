<?php
    session_start();
    require_once("TicTacToe.php");
    require_once("Player.php");
    require_once("Board.php");
    if(isset($_SESSION["Tictactoe"])){
        $game = unserialize($_SESSION["Tictactoe"]);
        if(isset($_GET)){
            $key = key($_GET);
            $matches = [];
            preg_match("/cell-(\d)-(\d)/",$key,$matches);
            $row = $matches[1];
            $column = $matches[2];
            $game->playTurn($row,$column,$_GET[$key]);
        }
    } else {
        $board = new Board();
        $playerOne = new Player("Marcel","X");
        $playerTwo = new Player("Marcel2","O");
        /** @noinspection PhpUndefinedClassInspection */
        $game = new TicTacToe($board, $playerOne, $playerTwo, $playerOne);
        $board->showBoard($playerOne);
    }

    $_SESSION["Tictactoe"] = serialize($game);

?>

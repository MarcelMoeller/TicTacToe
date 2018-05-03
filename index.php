<?php
    session_start();
    //Include classes
    require_once("TicTacToe.php");
    require_once("Player.php");
    require_once("Board.php");
    //Check if the $_SESSION variable contains the tictactoe object
    if(isset($_SESSION["Tictactoe"])){
        //Unserialize tictactoe variable
        /** @var \TicTacToe $game */
        $game = unserialize($_SESSION["Tictactoe"]);
        //Check if the $_GET variable is not empty
        if(isset($_GET) && !empty($_GET)){
            //Get all keys of the $_GET array
            $keys = array_keys($_GET);
            $matches = [];
            //Iterate through all keys and check if pregmatch gets a match
            for($i = 0; $i < count($keys); $i++) {
                preg_match("/cell-(\d)-(\d)/",$keys[$i],$matches);
                if(!empty($matches)) {
                    //Get the matched key and the groups 1 and 2 which contains the col and the row
                    $key = $keys[$i];
                    $row = $matches[1];
                    $col = $matches[2];
                    //Play a turn with the values of the $_GET variable
                    $game->playTurn($row,$col,$_GET[$key]);
                    //Break out of the for loop because it is only allowed to play a single turn per player.
                    //Without the break the game could be manipulated.
                    break;
                }
            }
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

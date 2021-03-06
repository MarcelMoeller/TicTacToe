<?php
    session_start();
    define('BASEPATH', realpath(dirname(__FILE__)));
    require_once (BASEPATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');
    //Restarts the game if the restart button gets pressed.
    if(isset($_GET["restart"]) && $_GET["restart"] == 1) {
        session_destroy();
        session_start();
    }

    //Check if the $_SESSION variable contains the tictactoe object
    if(isset($_SESSION["Tictactoe"]) && !empty($_SESSION["Tictactoe"])){
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
                preg_match("/^cell-(\d)-(\d)$/",$keys[$i],$matches);
                if(!empty($matches)) {
                    //Get the groups 1 and 2 which contains the col and the row
                    $row = $matches[1];
                    $col = $matches[2];
                    //Play a turn with the values of the $_GET variable
                    $game->playTurn($row,$col);
                    //Break out of the for loop because it is only allowed to play a single turn per player.
                    //Without the break the game could be manipulated.
                    break;
                }
            }
        }
    } else {
        //Create a new TicTacToe game including the board and the two players and show the empty board afterwards
        $board = new Board();
        $playerOne = new Player("Marcel","X");
        $playerTwo = new Player("Marcel2","O");
        /** @noinspection PhpUndefinedClassInspection */
        $game = new TicTacToe($board, $playerOne, $playerTwo, $playerOne);
    }

    include_once("templates/BoardTemplateTop.html");
    echo \Notification::getOutput();
    echo $game->showCurrentScore();
    echo $game->showBoard();
    include_once("templates/BoardTemplateBottom.html");


    //Safe the current TicTacToe game into a session
    $_SESSION["Tictactoe"] = serialize($game);

?>

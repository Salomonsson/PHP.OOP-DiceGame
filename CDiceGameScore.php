<?php
/**
 * Keep score alive with sessionsArray
 *
 */
class CDiceGameScore {

public static function setSumComputer($playerScore){
     $_SESSION['ComputerScore'] = $playerScore;
    }

public static function getSumComputer(){
     return $_SESSION['ComputerScore'];
    }

#///player sessions, score

public static function setSumPlayer($playerScore){
     $_SESSION['PlayerScore'][] = $playerScore;
    }
public static  function unsetSumPlayer(){
     unset($_SESSION['PlayerScore']);
    }

public static  function getSumPlayer(){
     return $_SESSION['PlayerScore'];
    }

public static  function setSumPlayerZero(){
     $_SESSION['PlayerScore'] = 0;
    }

}

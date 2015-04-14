<?php
/**
 * Save each game to session. For total Score
 *
 */
class CDiceHistory {
   /**
   * Constructor
   *
   */
  public function __construct() {
    $_SESSION['ComputerScoreHistory'] = 0;
    $_SESSION['PlayerScoreHistory'] = 0;
  }

   public static function setComputerScoreHistory(){
      $_SESSION['ComputerScoreHistory']++;
    }

   public static function getComputerScoreHistory(){
       return $_SESSION['ComputerScoreHistory'];
    }

   public static function setPlayerScoreHistory(){
      $_SESSION['PlayerScoreHistory']++;
    }

   public static function getPlayerScoreHistory(){
      return $_SESSION['PlayerScoreHistory'];
    }

    public static function setPlayerHistoryZero(){
      return $_SESSION['PlayerScoreHistory'] = 0;
    }
    public static function setComputerHistoryZero(){
      return $_SESSION['ComputerScoreHistory'] = 0;
    }

}

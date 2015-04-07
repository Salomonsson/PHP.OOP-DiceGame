<?php
/**
 * A CDice class to play around with a dice.
 *
 */
class CDiceHand extends CDiceImage  {
 
  // Here comes properties & methods
 
  /**
   * Properties
   *
   */

/**
 * Contructor
 */
public function __construct() {
  #echo __METHOD__;
  $this->kast     = isset($_POST['kast'])  ? true : false;
  $this->delete     = isset($_POST['delete'])  ? true : false;
  $this->stop     = isset($_POST['stop'])  ? true : false;
  $this->computer     = isset($_POST['computer'])  ? true : false;
  $this->newGame     = isset($_POST['newGame'])  ? true : false;
  $this->times = isset($_GET['roll']) && is_numeric($_GET['roll']) ? $_GET['roll'] : 1;
}
/**
 * Destructor
 */
public function __destruct() {
  #echo __METHOD__;
}

public function startOver(){
    unset($_SESSION['computerTotalScore']);
    CDiceGameScore::unsetSumPlayer();
    CDiceHistory::setPlayerHistoryZero();
    CDiceHistory::setComputerHistoryZero();
      $view = "<form method='post'>
            <input type='submit' name='kast'  value='Kasta startover' id='submit' />
          </form>";
  return $view;
}

public function RenderStartGame(){
    if($this->delete){
        return $this->startOver();
    }
    if($this->kast){
        return $this->playGame();
    }
    if($this->stop){
      return $this->saveGame();
    }
    if($this->computer){
        return $this->computerGame();
    }
    if($this->newGame){
          CDiceGameScore::unsetSumPlayer();
       return $view = 
                  " <form method='post'>
                    <input type='submit' name='kast'  value='Kasta' id='submit' /> 
                    <br> <br>
                    <input type='submit' name='delete'  value='Börja om' id='submit' /> 
                </form>";
    }
    else{
       CDiceHistory::setPlayerHistoryZero();
       CDiceHistory::setComputerHistoryZero();
         return $view = 
           " <form method='post'>
                <input type='submit' name='kast'  value='Starta Spel..' id='submit' /> 
                <br> <br>
            </form>";
            
    }
}

 public function renderScoreTable(){
         return $view = 
           "<h3>&nbsp;&nbsp;&nbsp;&nbsp; Scoretable <b>History</b>!</h3>" .
           "<h3>&nbsp;&nbsp;&nbsp;&nbsp; Dator: " . CDiceHistory::getComputerScoreHistory() .
             "&nbsp;&nbsp;&nbsp;&nbsp; Spelare: " . CDiceHistory::getPlayerScoreHistory() ."</h3>
           ";
    }

public function playGame(){
      $this->Roll($this->times);
      CDiceGameScore::setSumPlayer($this->GetTotalPlayer());

      $antalKast = "<h3>&nbsp;&nbsp;&nbsp;&nbsp; Antal kast: ". count(CDiceGameScore::getSumPlayer()) . "</h3>";
      $total     = "<h3>&nbsp;&nbsp;&nbsp;&nbsp; Detta kast: ".$this->GetTotalPlayer() . "</h3>";
      $antal     = "<h3>&nbsp;&nbsp;&nbsp;&nbsp; Alla slag: " .array_sum(CDiceGameScore::getSumPlayer()) . ".</h3>";
      $imageDice = $this->GetRollsAsImageObj(CDiceGameScore::getSumPlayer()); 
        
        ##//If- poäng mer än 21, unset spelare poäng.
        $stor = $this->goal(array_sum(CDiceGameScore::getSumPlayer()));
        $view = $antal .
                $antalKast .
                $total .
                $imageDice .
                $stor .
                  " <form method='post'>
                    <input type='submit' name='kast'  value='Kasta' id='submit' /> 
                    <input type='submit' name='stop'  value='Stanna' id='submit' /> 
                    <br> <br>
                    <input type='submit' name='delete'  value='Börja om' id='submit' /> 
                </form>";

  return $view;
}



public function goal($points){
  if ($points > 21) {
     CDiceGameScore::unsetSumPlayer();
     CDiceHistory::setComputerScoreHistory();
     return $stor = "<h3>&nbsp;&nbsp;&nbsp;&nbsp; <b>Tyvärr! Du fick över 21.</b></h3>";
  }
}




public function saveGame(){
    $total = "<h3>&nbsp;&nbsp;&nbsp;&nbsp; Du har valt att stanna på: " . array_sum(CDiceGameScore::getSumPlayer()) ."</h3>";
    $totalPlayerDiceImage = $this->GetRollsAsImageObj(CDiceGameScore::getSumPlayer());
      $view = $total . 
              $totalPlayerDiceImage .
            "<form method='post'>
            <input type='submit' name='computer'  value='Låt Dator Slå' id='submit' />
            <br><br>
            <input type='submit' name='kast'    value='Fortsätt Kasta' id='submit' /> 
            </form>";

  return $view;
}



public function checkWinner($score){
      if ($score >= array_sum(CDiceGameScore::getSumPlayer()) and  $score <= 21 ) {
        $html ="<h2>&nbsp;&nbsp;&nbsp;&nbsp;Vinst: <b>DATOR</b> </h2>";
        CDiceHistory::setComputerScoreHistory();
      }else{
          $html = "<h2>&nbsp;&nbsp;&nbsp;&nbsp;Vinst: <b>SPELARE</b> <h2>";
        CDiceHistory::setPlayerScoreHistory();
      }
      return $html;
}




public function computerGame(){
      ##//RollComputer tar emot inparameter, antalet poäng spelaren har stannat på, och där efter loopar fram tal.
    $this->RollComputer(array_sum(CDiceGameScore::getSumPlayer()));
    CDiceGameScore::setSumComputer($this->GetTotalasSessionComp());
    $total         = "<h3>&nbsp;&nbsp;&nbsp;&nbsp; SPELARE fick:" . array_sum(CDiceGameScore::getSumPlayer()) ." </h3>";
    $totalComputer = "<h3>&nbsp;&nbsp;&nbsp;&nbsp; DATORN fick:". $this->GetTotalasSessionCompScore() . "</h3>";
    $winner        = $this->checkWinner($this->GetTotalasSessionCompScore());
      ##/GetRollsAsImageObj - Bilder för tärningarna.  
    $totalPlayerDiceImage       = $this->GetRollsAsImageObj(CDiceGameScore::getSumComputer());#dator
    $totalPlayerDiceImageplayer = $this->GetRollsAsImageObj(CDiceGameScore::getSumPlayer());#spelare
      $view = 
            $total.
            $totalPlayerDiceImageplayer.
            $winner.
            $totalComputer .
            $totalPlayerDiceImage .
            "<form method='post'>
            <input type='submit' name='newGame'  value='Kasta ny runda' id='submit' /> 
            <input type='submit' name='delete'  value='Ny Spelomgång' id='submit' /> 
            </form>";
  
  return $view;
}


}

<?php  
/** 
 * This is a oop pagecontroller. 
 * 
 */ 
// Include the essential config-file which also creates the $oop variable with its defaults. 
include(__DIR__.'/config.php');  
$oop['javascript_include'][] = 'js/bootstrap.js';
$oop['stylesheets'][] = 'css/register.css';
$oop['stylesheets'][] = 'css/bootstrap.css';
$oop['stylesheets'][] = 'css/dice.css';

$db = new CDatabase($oop['database']);
$user = new CUser($db);
$diceGame = new CDiceHand();
$user->userPermission();

                      $html = "<h4>Välkommen <b>{$user->getName()}!</b><br>Tryck på Kasta för att spela!</h4><br><br>
                      			<h4>Får du över 21, så förlorar du. </h4>";
                    
                      $oop['title'] = "Dicegame";
                      $oop['left'] = <<<EOD
                      <h1 class="header1"> Dicegame!</h1>
                      <div class="testbox">
                      	{$diceGame->RenderStartGame()}
                      <br><br><br><br>
                      </div>
                      EOD;
                    
                      $oop['right'] = <<<EOD
                      <h1 class="header1"> Dicegame!</h1>
                      <div class="testbox">
                      	$html
                      	{$diceGame->renderScoreTable()}
                      </div>
                      EOD;
                      
                      $oop['under'] = <<<EOD
                      <h1 class="header1"> Dicegame!</h1>
                      EOD;
                      
                      
// Finally, leave it all to the rendering phase of Anax.
include(OOP_THEME_PATH);

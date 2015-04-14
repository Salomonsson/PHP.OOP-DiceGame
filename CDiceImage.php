<?php
/**
 * A dice with images as graphical representation.
 *
 */
class CDiceImage extends CDice {
 
  // Properties and methods extending or overriding base class
  const FACES = 6;

   /**
   * Constructor
   *
   */
  public function __construct() {
    parent::__construct(self::FACES);
  }

  /**
   * Get the rolls as a serie of images.
   *
   */
  public function GetRollsAsImageObj($score) {
    $html = "<ul class='dice'>";
    foreach($score as $val) {
      $html .= "<li class='dice-{$val}'></li>";
    }
    $html .= "</ul>";
    return $html;
  }

}

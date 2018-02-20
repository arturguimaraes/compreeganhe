<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arrayutil {

  protected $CI;

  public function __construct() {
    // Assign the CodeIgniter super-object
    $this->CI =& get_instance();
  }

  public function html_show_array($array){
    $resp = "<table cellspacing=\"0\" border=\"2\">\n";
    $resp .= $this->show_array($array, 1, 0);
    $resp .= "</table>\n";
    return $resp;
  }

  private function do_offset($level){
    $offset = "";             // offset for subarry 
    for ($i=1; $i<$level;$i++){
      $offset = $offset . "  ";
    }
    return $offset;
  }

  private function show_array($array, $level, $sub){
    $resp = "";
    if (is_array($array) == 1){          // check if input is an array
      foreach($array as $key_val => $value) {
        $offset = "";
        if (is_array($value) == 1){   // array is multidimensional
          $resp .= "<tr>";
          $offset = $this->do_offset($level);
          $resp .= $offset . "<td>" . $key_val . "</td>";
          $this->show_array($value, $level+1, 1);
        }
        else{                        // (sub)array is not multidim
          if ($sub != 1){          // first entry for subarray
            $resp .= "<tr nosub>";
            $offset = $this->do_offset($level);
          }
          $sub = 0;
          $resp .= $offset . "<td main ".$sub." width=\"120\">" . $key_val . 
                   "</td><td width=\"120\">ID: " . $value->id . "</td>"; 
          $resp .= "</tr>\n";
        }
      } //foreach $array
    }
    return $resp;
  }

}
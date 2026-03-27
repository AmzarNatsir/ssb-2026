<?php
namespace App\Helpers;
use App\models\Tender\Project;

class ProjectHelper 
{
  private function numberToRomanRepresentation($number)
  {
    $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
    $returnValue = '';
    while ($number > 0) {
        foreach ($map as $roman => $int) {
            if($number >= $int) {
                $number -= $int;
                $returnValue .= $roman;
                break;
            }
        }
    }
    return $returnValue;
  }

  public static function create_project_number()
  {
    // 4 digit no urut/PRO-SSB/DIGIT BULAN ROMAWI/4 DIGIT TAHUN
    // contoh : 0001/PRO-SSB/III/2021    
    // dd($this->max_order_digit);
    $monthInRoman = (new ProjectHelper())->numberToRomanRepresentation(date('m'));    
    $project = Project::orderByDesc('created_at')->limit(1)->select('number')->get()->first();    
    // $project = \App\models\Tender\Project::orderByDesc('created_at')->limit(1)->select('number')->get()->first();    
    $currentDigit = (int)substr($project->number, 0, 4) + 1; 
    $newDigit = str_pad($currentDigit, 4, "0", STR_PAD_LEFT);
    return $newDigit."/PRO-SSB/".$monthInRoman."/".date('Y');    
  }
}
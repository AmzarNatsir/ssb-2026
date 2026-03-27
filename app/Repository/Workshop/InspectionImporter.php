<?php

namespace App\Repository\Workshop;

class InspectionImporter
{

  public $file, $uploader;

  public function construct($file, $uploaded_by)
  {
    $this->file = $file;
    $this->uploader = $uploaded_by;
  }

  public function export()
  {
    # code...
  }


}


<?php

namespace app\Services;

class ImportService
{
    public function importFromJson($path){
      $json = json_decode(file_get_contents($path), true);

      foreach(array_chunk($json, 100) as $chunk){
        db_connect()->table('studentregisterationform')->insertBatch($chunk);
      }
    }
}
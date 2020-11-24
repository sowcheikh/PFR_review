<?php


namespace App\Services;



class UploadFile {
   public function uploadFile($avatar) {
       if ($avatar) {
           $file = fopen($avatar->getRealPath(),"rb");
            return $file;
       }
       return null;
   }
}

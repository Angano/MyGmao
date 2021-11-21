<?php
namespace App\Services ;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;

class CheckFormFileHelper extends AbstractController{

    public function checkFile($form, $type){

         //traitement fichier
         $fileUpload = $form->getData();
         if($fileUpload){
             $fileUploadName = time().'_'.$type.'.'.$fileUpload->guessExtension();
             $fileUpload->move($this->getParameter('UPLOAD_DIR'), $fileUploadName );
             return $fileUploadName;
         }
         else
         return false;

    }

    public function deleteFile($file){
     
        $fileSystem = new Filesystem();
        $fileDeleted = $this->getParameter('UPLOAD_DIR').$file;
        
        if($fileSystem->exists($fileDeleted) && $file !==''){
            $fileSystem->remove($fileDeleted);
            return true;
        } else {
            return false;
        }

    }


    public function updateFile($file, $form, $type){

        $this->deleteFile($file);
        return $this->checkFile($form, $type);
        
    }


}

<?php

namespace App\Handler\User;

use App\Base\BaseHandler;
use App\Entity\UserFile;
use App\Entity\User;
use DateTime;

class UserFileHandler extends BaseHandler
{
    public function create($user, $files){
        $userFile = new UserFile();
        foreach($files as $key => $file){
            $fileName = $this->prepareAndUploadFile($user->getId(), $key, $file);
            $this->setter($userFile, $user, $fileName);
        }
    }

    public function update($user, $files){
        $userFile = $user->getUserFile();
        foreach($files as $key => $file){
            $this->cleanerFile($file, $key, $user->getId());
            $fileName = $this->prepareAndUploadFile($user->getId(), $key, $file);
            $this->setter($userFile, $user, $fileName);
        }
    }

    public function prepareAndUploadFile($userId, $key, $file){
        $absoluteRoute = getcwd();
        $fileRoute     = $this->getParam('route_files');
        $entityFile    = $this->getParam('route_files_entity') . "User\\$userId";
        $route         = $absoluteRoute . $fileRoute . $entityFile;
        $fileName      = "$key-" . $file->getClientOriginalName();
        $file->move($route, $fileName);
        return $fileName;
    }

    public function delete($user){
        $this->cleanerEntity($user->getId());
    }

    public function searchFileByKey($key, $userId){
        $absoluteRoute = getcwd();
        $fileRoute     = $this->getParam('route_files');
        $entityFile    = $this->getParam('route_files_entity') . "User\\$userId";
        $route         = $absoluteRoute . $fileRoute . $entityFile;
    }

    private function setter(UserFile $userFile, User $user, $fileName){
        $field = explode("-",$fileName);
        switch($field[0]){
            case "backDni":
                $userFile->setBackDni($fileName);
                break;
            case "frontDni":
                $userFile->setFrontDni($fileName);
                break;
            case "profilePicture":
                $userFile->setProfilePicture($fileName);
                break;
        }
        $userFile->setUser($user);
        $this->getEm()->persist($userFile);
        $this->getEm()->flush();
        $user->setUserFile($userFile);
        return $userFile;
    }

    private function cleanerFile($file, $key, $userId){
        $absoluteRoute = getcwd();
        $fileRoute     = $this->getParam('route_files');
        $entityFile    = $this->getParam('route_files_entity') . "User\\$userId";
        $route         = $absoluteRoute . $fileRoute . $entityFile;
        $currentFiles  = array_diff(scandir($route), array('..', '.'));
        foreach($currentFiles as $currentFile){
            if(!is_null($key) && $key != "" && strpos($currentFile, $key) !== false){
                unlink($route . "\\" . $currentFile);
            }
        }
    }

    private function cleanerEntity($userId){
        $absoluteRoute = getcwd();
        $fileRoute     = $this->getParam('route_files');
        $entityFile    = $this->getParam('route_files_entity') . "User\\$userId";
        $route         = $absoluteRoute . $fileRoute . $entityFile;
        $currentFiles  = array_diff(scandir($route), array('..', '.'));
        foreach($currentFiles as $currentFile){
            unlink($route . "\\" . $currentFile);
        }
        rmdir($route);
    }

    private function validateFiles($user){
        return true;
    }
}

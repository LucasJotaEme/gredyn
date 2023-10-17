<?php

namespace App\Handler\Rol;

use App\Base\BaseHandler;
use App\Entity\Rol;
use DateTime;

class RolHandler extends BaseHandler
{

    public function create($params){
        $em               = $this->getEm();
        $rol              = new Rol();
        $rol              = $this->setter($rol, $params);
        $readyExist       = $this->getRepo('Rol')->findOneBy(array('name' => $rol->getName()));
        if(is_null($readyExist)){
            $validate = $this->validateFields($rol);
            if($validate){
                $em->persist($rol);
                $em->flush();
                return $rol;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("A rol with name " . $rol->getName() .  " already exists");
        }
    }

    public function updateName($params){
        $em               = $this->getEm();
        $rol              = $this->getRepo('Rol')->findOneBy(array('name' => $params['name']));
        if(!is_null($rol)){
            $rol->setName($params["newName"]);
            $validate     = $this->validateFields($rol);
            if($validate){
                $em->flush();
                return $rol;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The Rol isn't exists with name " . $params["name"]);
        }
    }

    public function delete($id){
        $em   = $this->getEm();
        $rol  = $this->getRepo('Rol')->find($id);
        if(!is_null($rol)){
            $em->remove($rol);
            $em->flush();
        }else{
            throw new \Exception("The Rol isn't exist");
        }
    }

    public function addUsers($content){
        $em               = $this->getEm();
        $rol              = $this->getRepo('Rol')->find($content->rolId);
        if(!is_null($rol)){
            foreach($content->users as $contentUser){
                $user     = $this->getRepo('User')->find($contentUser->id);
                if(!is_null($user)){
                    $rol->addUser($user);
                }else{
                    throw new \Exception("The User with id " . $contentUser->id . " was not found");        
                }
            }
            $em->flush();
            return $rol;
        }else{
            throw new \Exception("There is not a Rol with id " . $content->rolId);
        }
    }

    public function deleteUsers($content){
        $em               = $this->getEm();
        $rol              = $this->getRepo('Rol')->find($content->rolId);
        if(!is_null($rol)){
            foreach($content->users as $contentUser){
                $user     = $this->getRepo('User')->find($contentUser->id);
                if(!is_null($user)){
                    $rol->removeUser($user);
                }else{
                    throw new \Exception("The User with id " . $contentUser->id . " was not found");        
                }
            }
            $em->flush();
            return $rol;
        }else{
            throw new \Exception("There is not a Rol with id " . $content->rolId);
        }
    }

    private function setter(Rol $rol, $params){
        $rol->setName($params["name"]);
        return $rol;
    }

    private function validateFields(Rol $rol){
        return true;
    }
}

<?php

namespace App\Handler\User;

use App\Base\BaseHandler;
use App\Handler\User\UserFileHandler;
use App\Entity\User;
use App\Handler\Lender\LenderHandler;
use App\Handler\Client\ClientHandler;
use DateTime;

class UserHandler extends BaseHandler
{   
    public $userHandler;
    public $lenderHandler;
    public $clientHandler;

    public function __construct(UserFileHandler $userFileHandler, LenderHandler $lenderHandler, ClientHandler $clientHandler){
        $this->userFileHandler = $userFileHandler;
        $this->lenderHandler   = $lenderHandler;
        $this->clientHandler   = $clientHandler;
    }

    public function create($params){
        $em               = $this->getEm();
        $user             = new User();
        $user             = $this->setter($user, $params);
        $readyExist       = $this->getRepo('User')->findOneBy(array('email' => $user->getEmail()));
        if(is_null($readyExist)){
            $readyExist   = $this->getRepo('User')->findOneBy(array('userName' => $user->getUserName()));
            if(is_null($readyExist)){
                $validate = $this->validateFields($user);
                if($validate){
                    $this->createLender($user, $params);
                    $this->clientHandler->create($user);
                    $this->userFileHandler->create($user, $params["files"]);
                    $em->persist($user);
                    $em->flush();
                    return $user;
                }else{
                    throw new \Exception($validate);
                }
            }else{
                throw new \Exception("A user with username " . $user->getUsername() . " already exists");    
            }
        }else{
            throw new \Exception("A user with email " . $user->getEmail() .  " already exists");
        }
    }

    public function update($params){
        $em               = $this->getEm();
        $user             = $this->getRepo('User')->findOneBy(array('userName' => $params["userName"]));
        if(!is_null($user)){
            $user         = $this->setter($user, $params);
            $validate     = $this->validateFields($user);
            if($validate){
                if(isset($params["files"])){
                    $this->userFileHandler->update($user, $params["files"]);
                }
                $em->flush();
                return $user;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The User isn't exists with user name " . $params["userName"]);
        }
    }

    public function updateUserName($params){
        $em               = $this->getEm();
        $user             = $this->getRepo('User')->findOneBy(array('userName' => $params["userName"]));
        if(!is_null($user)){
            $user->setUserName($params["newUserName"]);
            $validate     = $this->validateFields($user);
            if($validate){
                $em->flush();
                return $user;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The User isn't exists with user name " . $params["userName"]);
        }
    }

    public function delete($id){
        $em   = $this->getEm();
        $user = $this->getRepo('User')->findOneBy(array('id' => $id));
        if(!is_null($user)){
            $em->remove($user);
            $this->userFileHandler->delete($user);
            $em->flush();
        }else{
            throw new \Exception("The User isn't exist");
        }
    }

    public function addRoles($content){
        $em               = $this->getEm();
        $user             = $this->getRepo('User')->find($content->userId);
        if(!is_null($user)){
            foreach($content->roles as $contentRol){
                $rol     = $this->getRepo('Rol')->find($contentRol->id);
                if(!is_null($rol)){
                    $user->addRolesEntity($rol);
                }else{
                    throw new \Exception("The Rol with id " . $contentRol->id . " was not found");        
                }
            }
            $em->flush();
            return $user;
        }else{
            throw new \Exception("There is not a User with id " . $content->userId);
        }
    }

    public function deleteRoles($content){
        $em               = $this->getEm();
        $user             = $this->getRepo('User')->find($content->userId);
        if(!is_null($user)){
            foreach($content->roles as $contentRol){
                $rol     = $this->getRepo('Rol')->find($contentRol->id);
                if(!is_null($rol)){
                    $user->removeRolesEntity($rol);
                }else{
                    throw new \Exception("The Rol with id " . $contentRol->id . " was not found");        
                }
            }
            $em->flush();
            return $user;
        }else{
            throw new \Exception("There is not a User with id " . $content->userId);
        }
    }

    private function createLender($user, $params){
        $lenderStatus = "";
        $description  = "";

        if(isset($params['lenderStatus'])){
            $lenderStatus = $params['lenderStatus'];
        }
        if(isset($params['description'])){
            $description  = $params['description'];
        }
        return $this->lenderHandler->create($user, $lenderStatus, $description);
    }

    private function setter(User $user, $params){
        $user->setEmail($params["email"]);
        $user->setUserName($params["userName"]);
        $user->setPassword(password_hash($params["password"], PASSWORD_DEFAULT));
        $user->setCreated(new DateTime());
        $user->setDni($params["dni"]);
        $user->setLoginCount(1);
        $user->setPhoneNumber($params["phoneNumber"]);
        $user->setBirthday($params["birthday"]);
        return $user;
    }

    private function validateFields(User $user){
        return true;
    }
}

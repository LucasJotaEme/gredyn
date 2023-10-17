<?php

namespace App\Controller;

use App\Handler\User\UserHandler;
use App\Base\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends BaseController
{
    private $userHandler;

    public function __construct(UserHandler $userHandler){
        $this->userHandler = $userHandler;
    }

    /**
     * @Route("/createUser"),
     * methods={"POST"},
     * params = {userName, email, password, dni, phoneNumber, birthday, backDni}
    */
    public function createUser(Request $request){
        $params = $this->getParams(array('userName', 'email', 'password', 'dni', 'phoneNumber', 'birthday', 'frontDni', 'backDni'), $request);
        if(is_null($params["error"])){
            try{
                $user = $this->userHandler->create($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($user, array($user->getUserFile(), $user->getLender(), $user->getClient())));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/updateUser"),
     * methods={"POST"},
     * params = {userName, email, password, dni, phoneNumber, birthday}
    */
    public function updateUser(Request $request){
        $params = $this->getParams(array('userName', 'email', 'password', 'dni', 'phoneNumber', 'birthday'), $request);
        if(is_null($params["error"])){
            try{
                $user = $this->userHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($user, array($user->getUserFile(), $user->getLender(), $user->getClient())));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/updateUserName"),
     * methods={"POST"},
     * params = {userName, newUserName}
    */
    public function updateUserName(Request $request){
        $params = $this->getParams(array('userName', 'newUserName'), $request);
        if(is_null($params["error"])){
            try{
                $user = $this->userHandler->updateUserName($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($user, array($user->getUserFile(), $user->getLender(), $user->getClient())));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteUser/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteUser(Request $request, $id){
        try{
            $this->userHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }

    /**
     * @Route("/user/addRoles"),
     * methods={"POST"},
     * contentParams = {userId, roles}
    */
    public function addRolesToUser(Request $request){
        $content = $this->getRequestContent(array("userId", "roles"), $request);
        if(!isset($content["error"])){
            try{
                $user = $this->userHandler->addRoles($content["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $content["error"]));
        }
        return $this->createResultResponse($this->serializer($user, array($user->getRolesEntity())));
    }

    /**
     * @Route("/user/deleteRoles"),
     * methods={"POST"},
     * contentParams = {userId, roles}
    */
    public function deleteRolesToUser(Request $request){
        $content = $this->getRequestContent(array("userId", "roles"), $request);
        if(!isset($content["error"])){
            try{
                $user = $this->userHandler->deleteRoles($content["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $content["error"]));
        }
        return $this->createResultResponse($this->serializer($user, array($user->getRolesEntity())));
    }
}


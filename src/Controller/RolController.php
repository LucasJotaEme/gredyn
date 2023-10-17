<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Rol\RolHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RolController extends BaseController
{
    private $rolHandler;
    
    public function __construct(RolHandler $rolHandler){
        $this->rolHandler = $rolHandler;
    }

    /**
     * @Route("/createRol"),
     * methods={"POST"},
     * params = {name}
    */
    public function createRol(Request $request){
        $params = $this->getParams(array('name'), $request);
        if(is_null($params["error"])){
            try{
                $rol = $this->rolHandler->create($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($rol, array($rol->getUsers())));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/updateRol"),
     * methods={"POST"},
     * params = {name, newName}
    */
    public function updateRol(Request $request){
        $params = $this->getParams(array('name', 'newName'), $request);
        if(is_null($params["error"])){
            try{
                $rol = $this->rolHandler->updateName($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($rol, array($rol->getUsers())));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteRol/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteRol(Request $request, $id){
        try{
            $this->rolHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }

    /**
     * @Route("/rol/addUsers"),
     * methods={"POST"},
     * contentParams = {rolId, users}
    */
    public function addUsersToRol(Request $request){
        $content = $this->getRequestContent(array("rolId", "users"), $request);
        if(!isset($content["error"])){
            try{
                $rol = $this->rolHandler->addUsers($content["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $content["error"]));
        }
        return $this->createResultResponse($this->serializer($rol, array($rol->getUsers())));
    }

    /**
     * @Route("/rol/deleteUsers"),
     * methods={"POST"},
     * contentParams = {rolId, users}
    */
    public function deleteUsersToRol(Request $request){
        $content = $this->getRequestContent(array("rolId", "users"), $request);
        if(!isset($content["error"])){
            try{
                $rol = $this->rolHandler->deleteUsers($content["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $content["error"]));
        }
        return $this->createResultResponse($this->serializer($rol, array($rol->getUsers())));
    }
}


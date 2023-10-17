<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Service\ServiceHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends BaseController
{
    private $serviceHandler;
    
    public function __construct(ServiceHandler $serviceHandler){
        $this->serviceHandler = $serviceHandler;
    }

    /**
     * @Route("/createService"),
     * methods={"POST"},
     * params = {status, clientAndLenderId, categoryId}
    */
    public function createService(Request $request){
        $params = $this->getParams(array('status', 'clientAndLenderId', 'categoryId'), $request);
        if(is_null($params["error"])){
            try{
                $service = $this->serviceHandler->create($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($service, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/updateService"),
     * methods={"POST"},
     * params = {serviceId, status}
    */
    public function updateService(Request $request){
        $params = $this->getParams(array('serviceId', 'status'), $request);
        if(is_null($params["error"])){
            try{
                $service = $this->serviceHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($service, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteService/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteService(Request $request, $id){
        try{
            $this->serviceHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }

    // PENDIENTES PARA UTILIZAR CON QUALIFICATION

    /**
     * @Route("/category/addClientAndLender"),
     * methods={"POST"},
     * contentParams = {categoryId, clientsAndLenders}
    */
    public function addClientAndLenderToCategory(Request $request){
        $content = $this->getRequestContent(array("categoryId", "clientsAndLenders"), $request);
        if(!isset($content["error"])){
            try{
                $category = $this->categoryHandler->addClientsAndLenders($content["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $content["error"]));
        }
        return $this->createResultResponse($this->serializer($category, array()));
    }

    /**
     * @Route("/category/deleteClientAndLender"),
     * methods={"POST"},
     * contentParams = {categoryId, clientsAndLenders}
    */
    public function deleteUsersToRol(Request $request){
        $content = $this->getRequestContent(array("categoryId", "clientsAndLenders"), $request);
        if(!isset($content["error"])){
            try{
                $category = $this->categoryHandler->removeClientsAndLenders($content["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $content["error"]));
        }
        return $this->createResultResponse($this->serializer($category, array()));
    }
}


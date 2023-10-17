<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Category\CategoryHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends BaseController
{
    private $categoryHandler;
    
    public function __construct(CategoryHandler $categoryHandler){
        $this->categoryHandler = $categoryHandler;
    }

    /**
     * @Route("/createCategory"),
     * methods={"POST"},
     * params = {price, totalPrice, starRating, photo}
    */
    public function createCategory(Request $request){
        $params = $this->getParams(array('name', 'price','totalPrice', 'starRating', 'photo'), $request);
        if(is_null($params["error"])){
            try{
                $category = $this->categoryHandler->create($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($category, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/updateCategory"),
     * methods={"POST"},
     * params = {name, newName}
    */
    public function updateCategory(Request $request){
        $params = $this->getParams(array('categoryId'), $request);
        if(is_null($params["error"])){
            try{
                $category = $this->categoryHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($category, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteCategory/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteCategory(Request $request, $id){
        try{
            $this->categoryHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }

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


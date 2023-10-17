<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Category\CategoryTypeHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoryTypeController extends BaseController
{
    private $categoryTypeHandler;
    
    public function __construct(CategoryTypeHandler $categoryTypeHandler){
        $this->categoryTypeHandler = $categoryTypeHandler;
    }

    /**
     * @Route("/createCategoryType"),
     * methods={"POST"},
     * params = {categoryId, price, totalPrice, starRating, photo}
    */
    public function createCategoryType(Request $request){
        $params = $this->getParams(array('categoryId','type', 'price'), $request);
        if(is_null($params["error"])){
            try{
                $categoryType = $this->categoryTypeHandler->create($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($categoryType, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/updateCategoryType"),
     * methods={"POST"},
     * params = {categoryIdType}
    */
    public function updateCategoryType(Request $request){
        $params = $this->getParams(array('categoryTypeId'), $request);
        if(is_null($params["error"])){
            try{
                $categoryType = $this->categoryTypeHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($categoryType, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteCategoryType/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteCategoryType(Request $request, $id){
        try{
            $this->categoryTypeHandler->delete($id);
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
                $category = $this->categoryTypeHandler->addClientsAndLenders($content["result"]);
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
                $category = $this->categoryTypeHandler->removeClientsAndLenders($content["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $content["error"]));
        }
        return $this->createResultResponse($this->serializer($category, array()));
    }
}


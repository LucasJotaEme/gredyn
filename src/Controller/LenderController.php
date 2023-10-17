<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Lender\LenderHandler;
use App\Handler\Lender\LenderOwnerHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LenderController extends BaseController
{
    private $lenderHandler;
    private $lenderOwnerHandler;
    
    public function __construct(LenderHandler $lenderHandler, LenderOwnerHandler $lenderOwnerHandler){
        $this->lenderHandler = $lenderHandler;
        $this->lenderOwnerHandler = $lenderOwnerHandler;
    }

    /**
     * @Route("/updateLender"),
     * methods={"POST"},
     * params = {lenderId, lenderStatus, description}
    */
    public function updateLender(Request $request){
        $params = $this->getParams(array('lenderId', 'lenderStatus', 'description'), $request);
        if(is_null($params["error"])){
            try{
                $lender = $this->lenderHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());
            }
            return $this->createResultResponse($this->serializer($lender, array($lender->getUser())));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteLender/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteLender(Request $request, $id){
        try{
            $this->lenderHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }

    /**
     * @Route("/lender/convertOwner/{lenderId}"),
     * methods={"GET"},
     * params = {lenderId}
    */
    public function convertOwner(Request $request, $lenderId){
        try{
            $lender = $this->lenderOwnerHandler->convertOwner($lenderId);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());
        }
        return $this->createResultResponse($this->serializer($lender, array($lender->getUser())));
    }

    /**
     * @Route("/lender/unconvertOwner/{lenderId}"),
     * methods={"GET"},
     * params = {lenderId}
    */
    public function unconvertOwner(Request $request, $lenderId){
        try{
            $lender = $this->lenderOwnerHandler->unconvertOwner($lenderId);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());
        }
        return $this->createResultResponse($this->serializer($lender, array($lender->getUser())));
    }
}


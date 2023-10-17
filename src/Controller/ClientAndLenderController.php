<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\ClientAndLender\ClientAndLenderHandler;
use App\Handler\Lender\LenderOwnerHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientAndLenderController extends BaseController
{
    private $clientAndlenderHandler;
    
    public function __construct(ClientAndLenderHandler $clientAndlenderHandler){
        $this->clientAndlenderHandler = $clientAndlenderHandler;
    }

    /**
     * @Route("/updateClientAndLender"),
     * methods={"POST"},
     * params = {clientAndLenderId, countServicesTotal}
    */
    public function updateClientAndLender(Request $request){
        $params = $this->getParams(array('clientAndLenderId', 'countServicesTotal'), $request);
        if(is_null($params["error"])){
            try{
                $clientAndlender = $this->clientAndlenderHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());
            }
            return $this->createResultResponse($this->serializer($clientAndlender, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }
}


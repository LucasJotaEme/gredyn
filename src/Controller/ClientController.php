<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Client\ClientHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends BaseController
{
    private $clientHandler;
    
    public function __construct(ClientHandler $clientHandler){
        $this->clientHandler = $clientHandler;
    }

    /**
     * @Route("/updateClient"),
     * methods={"POST"},
     * params = {clientId}
    */
    public function updateClient(Request $request){
        $params = $this->getParams(array('clientId'), $request);
        if(is_null($params["error"])){
            try{
                $client = $this->clientHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());
            }
            return $this->createResultResponse($this->serializer($client, array($client->getUser())));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteClient/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteClient(Request $request, $id){
        try{
            $this->clientHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }
}


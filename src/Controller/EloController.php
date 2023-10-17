<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Elo\EloHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EloController extends BaseController
{
    private $eloHandler;
    
    public function __construct(EloHandler $eloHandler){
        $this->eloHandler = $eloHandler;
    }

    /**
     * @Route("/updateElo"),
     * methods={"POST"},
     * params = {eloId, measurer, positive, negative, eloStatus}
    */
    public function updateElo(Request $request){
        $params = $this->getParams(array('eloId'), $request);
        if(is_null($params["error"])){
            try{
                $elo = $this->eloHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());
            }
            return $this->createResultResponse($this->serializer($elo, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteElo/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteElo(Request $request, $id){
        try{
            $this->eloHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }
}


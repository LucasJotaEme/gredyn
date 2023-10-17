<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Ranking\RankingHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RankingController extends BaseController
{
    private $rankingHandler;
    
    public function __construct(RankingHandler $rankingHandler){
        $this->rankingHandler = $rankingHandler;
    }

    // /**
    //  * @Route("/createRanking"),
    //  * methods={"POST"},
    //  * params = {name}
    // */
    // public function createRanking(Request $request){
    //     $params = $this->getParams(array('name', 'numberFrom', 'numberTo'), $request);
    //     if(is_null($params["error"])){
    //         try{
    //             $rol = $this->rolHandler->create($params["result"]);
    //         }catch(\Exception $e){
    //             return $this->createErrorResponse($e->getMessage());        
    //         }
    //         return $this->createResultResponse($this->serializer($rol, array($rol->getUsers())));
    //     }else{
    //         return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
    //     }
    // }

    /**
     * @Route("/updateRanking"),
     * methods={"POST"},
     * params = {clientId}
    */
    public function updateRanking(Request $request){
        $params = $this->getParams(array('rankingId'), $request);
        if(is_null($params["error"])){
            try{
                $ranking = $this->rankingHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());
            }
            return $this->createResultResponse($this->serializer($ranking, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deleteRanking/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deleteRanking(Request $request, $id){
        try{
            $this->rankingHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }
}


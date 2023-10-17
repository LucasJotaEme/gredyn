<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Unranked\UnrankedHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UnrankedController extends BaseController
{
    private $unrankedHandler;
    
    public function __construct(UnrankedHandler $unrankedHandler){
        $this->unrankedHandler = $unrankedHandler;
    }

    /**
     * @Route("/udpateUnranked"),
     * methods={"POST"},
     * params = {unrankedId, starRating}
    */
    public function updateUnranked(Request $request){
        $params = $this->getParams(array('unrankedId', 'starRating'), $request);
        if(is_null($params["error"])){
            try{
                $unranked = $this->unrankedHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());
            }
            return $this->createResultResponse($this->serializer($unranked, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }
}


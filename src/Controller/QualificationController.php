<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Qualification\QualificationHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class QualificationController extends BaseController
{
    private $qualificationHandler;
    
    public function __construct(QualificationHandler $qualificationHandler){
        $this->qualificationHandler = $qualificationHandler;
    }

    /**
     * @Route("/createQualification"),
     * methods={"POST"},
     * params = {serviceId, countStars, description}
    */
    public function createQualification(Request $request){
        $params = $this->getParams(array('serviceId', 'countStars', 'description'), $request);
        if(is_null($params["error"])){
            try{
                $qualification = $this->qualificationHandler->create($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($qualification, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/updateQualification"),
     * methods={"POST"},
     * params = {qualificationId, countStars, description}
    */
    public function updateQualification(Request $request){
        $params = $this->getParams(array('qualificationId'), $request);
        if(is_null($params["error"])){
            try{
                $qualification = $this->qualificationHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($qualification, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }
}


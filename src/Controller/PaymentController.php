<?php

namespace App\Controller;

use App\Base\BaseController;
use App\Handler\Payment\PaymentHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends BaseController
{
    private $paymentHandler;
    
    public function __construct(PaymentHandler $paymentHandler){
        $this->paymentHandler = $paymentHandler;
    }

    /**
     * @Route("/createPayment"),
     * methods={"POST"},
     * params = {serviceId, mount}
    */
    public function createPayment(Request $request){
        $params = $this->getParams(array('serviceId', 'mount'), $request);
        if(is_null($params["error"])){
            try{
                $payment = $this->paymentHandler->create($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($payment, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/updatePayment"),
     * methods={"POST"},
     * params = {paymentId}
    */
    public function updatePayment(Request $request){
        $params = $this->getParams(array('paymentId'), $request);
        if(is_null($params["error"])){
            try{
                $payment = $this->paymentHandler->update($params["result"]);
            }catch(\Exception $e){
                return $this->createErrorResponse($e->getMessage());        
            }
            return $this->createResultResponse($this->serializer($payment, array()));
        }else{
            return $this->createErrorResponse("Params not found: ". implode(", ", $params["error"]));
        }
    }

    /**
     * @Route("/deletePayment/{id}"),
     * methods={"GET"},
     * params = {id}
    */
    public function deletePayment(Request $request, $id){
        try{
            $this->paymentHandler->delete($id);
        }catch(\Exception $e){
            return $this->createErrorResponse($e->getMessage());        
        }
        return $this->createResultResponse("OK");
    }
}


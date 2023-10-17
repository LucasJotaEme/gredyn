<?php

namespace App\Handler\Payment;

use App\Base\BaseHandler;
use App\Entity\Payment;
use App\Entity\Qualification;
use DateTime;

class PaymentHandler extends BaseHandler
{

    public function create($params){
        $em         = $this->getEm();
        $payment    = new Payment();
        $payment    = $this->setter($payment, $params);
        if(!is_null($payment->getService())){
            $readyExist   = $this->getRepo('Payment')->findOneBy(array('service' => $payment->getService()));
            if(is_null($readyExist)){
                $validate = $this->validateFields($payment);
                if($validate){
                    $em->persist($payment);
                    $em->flush();
                    return $payment;
                }else{
                    throw new \Exception($validate);
                }
            }else{
                throw new \Exception("Payment with service id " . $payment->getService()->getId() . " ready exists");
            }
        }else{
            throw new \Exception("Payment not found the service");
        }
    }

    public function update($params){
        $em           = $this->getEm();
        $payment      = $this->getRepo('Payment')->find($params['paymentId']);
        if(!is_null($payment)){
            $payment  = $this->setter($payment, $params);
            $validate = $this->validateFields($payment);
            if($validate){
                $em->flush();
                return $payment;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The payment not exists with id " . $params["paymentId"]);
        }
    }

    public function delete($id){
        $em      = $this->getEm();
        $payment = $this->getRepo('Payment')->find($id);
        if(!is_null($payment)){
            $em->remove($payment);
            $em->flush();
        }else{
            throw new \Exception("The payment not exists");
        }
    }

    private function setter(Payment $payment, $params){
        if(isset($params["mount"])){
            $payment->setMount($params["mount"]);
        }
        if(isset($params["serviceId"])){
            $service = $this->getRepo('Service')->find($params["serviceId"]);
            $payment->setService($service);
            $payment->setCreated(new DateTime());
        }
        return $payment;
    }

    private function validateFields(Payment $payment){
        return true;
    }
}

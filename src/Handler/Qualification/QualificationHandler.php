<?php

namespace App\Handler\Qualification;

use App\Base\BaseHandler;
use App\Entity\Qualification;
use DateTime;

class QualificationHandler extends BaseHandler
{

    public function create($params){
        $em               = $this->getEm();
        $qualification    = new Qualification();
        $qualification    = $this->setter($qualification, $params);
        if(!is_null($qualification->getService())){
            $readyExist   = $this->getRepo('Qualification')->findOneBy(array('service' => $qualification->getService()));
            if(is_null($readyExist)){
                $validate = $this->validateFields($qualification);
                if($validate){
                    $em->persist($qualification);
                    $em->flush();
                    return $qualification;
                }else{
                    throw new \Exception($validate);
                }
            }else{
                throw new \Exception("Qualification with service id " . $qualification->getService()->getId() . " ready exists");    
            }
        }else{
            throw new \Exception("Qualification not found the service");
        }
    }

    public function update($params){
        $em                = $this->getEm();
        $qualification     = $this->getRepo('Qualification')->find($params['qualificationId']);
        if(!is_null($qualification)){
            $qualification = $this->setter($qualification, $params);
            $validate      = $this->validateFields($qualification);
            if($validate){
                $em->flush();
                return $qualification;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The qualification not exists with id " . $params["qualificationId"]);
        }
    }

    private function setter(Qualification $qualification, $params){
        if(isset($params["countStars"])){
            $qualification->setCountStars($params["countStars"]);
        }
        if(isset($params["serviceId"])){
            $service = $this->getRepo('Service')->find($params["serviceId"]);
            $qualification->setService($service);
        }
        if(isset($params["description"])){
            $qualification->setDescription($params["description"]);
        }
        return $qualification;
    }

    private function validateFields(Qualification $service){
        return true;
    }
}

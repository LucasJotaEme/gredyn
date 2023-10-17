<?php

namespace App\Handler\Unranked;

use App\Base\BaseHandler;
use App\Entity\ClientAndLender;
use App\Entity\Unranked;
use DateTime;

class UnrankedHandler extends BaseHandler
{
    // No hay servicio create. Sólo se lo crea desde clientAndLender.
    public function create(ClientAndLender $clientAndLender){
        $em         = $this->getEm();
        $unranked   = new Unranked();

        $unranked   = $this->setter($unranked, $clientAndLender);
        $validate   = $this->validateFields($unranked);
        if($validate){
            $em->persist($unranked);
            $em->flush();
            return $unranked;
        }else{
            throw new \Exception($validate);
        }
    }

    public function update($params){
        $em                  = $this->getEm();
        $unranked     = $this->getRepo('Unranked')->find($params['unrankedId']);
        if(!is_null($unranked)){
            $unranked = $this->paramsSetter($unranked, $params);
            $validate = $this->validateFields($unranked);
            if($validate){
                $em->flush();
                return $unranked;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The unranked isn't exists with id " . $params["unrankedId"]);
        }
    }

    public function delete($id){
        $em       = $this->getEm();
        $unranked = $this->getRepo('Unranked')->find($id);
        if(!is_null($unranked)){
            $em->remove($unranked);
            $em->flush();
        }else{
            throw new \Exception("The unranked isn't exist");
        }
    }

    private function setter(Unranked $unranked, ClientAndLender $clientAndLender){
        $unranked->setClientAndLender($clientAndLender);
        return $unranked;
    }

    private function paramsSetter(Unranked $unranked, $params){
        $unranked->setStarRating($params['starRating']);
        return $unranked;
    }

    private function validateFields(Unranked $rol){
        return true;
    }
}

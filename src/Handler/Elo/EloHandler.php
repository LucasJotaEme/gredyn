<?php

namespace App\Handler\Elo;

use App\Base\BaseHandler;
use App\Entity\ClientAndLender;
use App\Entity\Elo;
use App\Entity\Lender;
use App\Entity\User;
use App\Handler\ClientAndLender\ClientAndLenderHandler;
use DateTime;

class EloHandler extends BaseHandler
{
    
    public function __construct(){
    }

    // No hay servicio create. Sólo se lo crea desde ClientAndLender.
    public function create(ClientAndLender $clientAndLender){
        $em       = $this->getEm();
        $elo      = new Elo();
        $elo      = $this->setter($elo, $clientAndLender);
        $validate = $this->validateFields($elo);
        if($validate){
            $em->persist($elo);
            $em->flush();
            return $elo;
        }else{
            throw new \Exception($validate);
        }
    }

    public function update($params){
        $em                  = $this->getEm();
        $elo                 = $this->getRepo('Elo')->find($params['eloId']);
        if(!is_null($elo)){
            $elo             = $this->paramsSetter($elo, $params);
            $validate        = $this->validateFields($elo);
            if($validate){
                $em->flush();
                return $elo;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The Elo not exist with id " . $params["eloId"]);
        }
    }

    public function delete($id){
        $em      = $this->getEm();
        $elo     = $this->getRepo('Elo')->find($id);
        if(!is_null($elo)){
            $em->remove($elo);
            $em->flush();
        }else{
            throw new \Exception("The Elo not exist");
        }
    }

    private function setter(Elo $elo, ClientAndLender $clientAndLender){
        $elo->setClientAndLender($clientAndLender);
        return $elo;
    }

    private function paramsSetter(Elo $elo, $params){
        if(isset($params["measurer"])){
            $elo->setMeasurer($params["measurer"]);
        }
        if(isset($params["positive"])){
            $elo->setPositive($params["positive"]);
        }
        if(isset($params["negative"])){
            $elo->setNegative($params["negative"]);
        }
        if(isset($params["eloStatus"])){
            $elo->setEloStatus($params["eloStatus"]);
        }
        return $elo;
    }

    private function validateFields(Elo $rol){
        return true;
    }
}

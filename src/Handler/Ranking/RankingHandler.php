<?php

namespace App\Handler\Ranking;

use App\Base\BaseHandler;
use App\Entity\Lender;
use App\Entity\Ranking;
use App\Entity\User;
use DateTime;

class RankingHandler extends BaseHandler
{
    // public function create(User $user, $lenderStatus = "", $description = ""){
    //     $em       = $this->getEm();
    //     $lender   = new Lender();
    //     $lender   = $this->setter($lender, $lenderStatus, $description, $user);
    //     $validate = $this->validateFields($lender);
    //     if($validate){
    //         $this->clientAndlenderHandler->create(null, $lender);
    //         $em->persist($lender);
    //         $em->flush();
    //         return $lender;
    //     }else{
    //         throw new \Exception($validate);
    //     }
    // }

    public function update($params){
        $em                  = $this->getEm();
        $ranking             = $this->getRepo('Ranking')->find($params['rankingId']);
        if(!is_null($ranking)){
            $ranking         = $this->paramsSetter($ranking, $params);
            $validate        = $this->validateFields($ranking);
            if($validate){
                $em->flush();
                return $ranking;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The Ranking not exists with id " . $params["rankingId"]);
        }
    }

    public function delete($id){
        $em      = $this->getEm();
        $ranking  = $this->getRepo('Ranking')->find($id);
        if(!is_null($ranking)){
            $em->remove($ranking);
            $em->flush();
        }else{
            throw new \Exception("The Ranking not exists");
        }
    }

    // private function setter(Lender $lender, $lenderStatus, $description, User $user){
    //     $lender->setLenderStatus($lenderStatus);
    //     $lender->setDescription($description);
    //     $lender->setUser($user);
    //     return $lender;
    // }

    private function paramsSetter(Ranking $ranking, $params){
        if(isset($params["name"])){
            $ranking->setName($params["name"]);
        }
        if(isset($params["numberFrom"])){
            $ranking->setNumberFrom($params["numberFrom"]);
        }
        if(isset($params["numberTo"])){
            $ranking->setNumberTo($params["numberTo"]);
        }
        return $ranking;
    }

    private function validateFields(Ranking $ranking){
        return true;
    }
}

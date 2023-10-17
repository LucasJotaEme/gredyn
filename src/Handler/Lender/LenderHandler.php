<?php

namespace App\Handler\Lender;

use App\Base\BaseHandler;
use App\Entity\Lender;
use App\Entity\User;
use App\Handler\ClientAndLender\ClientAndLenderHandler;
use DateTime;

class LenderHandler extends BaseHandler
{
    private $clientAndlenderHandler;
    
    public function __construct(ClientAndLenderHandler $clientAndlenderHandler){
        $this->clientAndlenderHandler = $clientAndlenderHandler;
    }

    // No hay servicio create. Sólo se lo crea desde user.
    public function create(User $user, $lenderStatus = "", $description = ""){
        $em       = $this->getEm();
        $lender   = new Lender();
        $lender   = $this->setter($lender, $lenderStatus, $description, $user);
        $validate = $this->validateFields($lender);
        if($validate){
            $this->clientAndlenderHandler->create(null, $lender);
            $em->persist($lender);
            $em->flush();
            return $lender;
        }else{
            throw new \Exception($validate);
        }
    }

    public function update($params){
        $em                  = $this->getEm();
        $lender              = $this->getRepo('Lender')->find($params['lenderId']);
        if(!is_null($lender)){
            $lender       = $this->paramsSetter($lender, $params);
            $validate     = $this->validateFields($lender);
            if($validate){
                $em->flush();
                return $lender;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The Lender isn't exists with id " . $params["lenderId"]);
        }
    }

    public function delete($id){
        $em      = $this->getEm();
        $lender  = $this->getRepo('Lender')->find($id);
        if(!is_null($lender)){
            $em->remove($lender);
            $em->flush();
        }else{
            throw new \Exception("The Lender isn't exist");
        }
    }

    private function setter(Lender $lender, $lenderStatus, $description, User $user){
        $lender->setLenderStatus($lenderStatus);
        $lender->setDescription($description);
        $lender->setUser($user);
        return $lender;
    }

    private function paramsSetter(Lender $lender, $params){
        $lender->setLenderStatus($params['lenderStatus']);
        $lender->setDescription($params['description']);
        return $lender;
    }

    private function validateFields(Lender $rol){
        return true;
    }
}

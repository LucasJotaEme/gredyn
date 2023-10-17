<?php

namespace App\Handler\ClientAndLender;

use App\Base\BaseHandler;
use App\Entity\Lender;
use App\Entity\Client;
use App\Entity\ClientAndLender;
use App\Entity\User;
use App\Handler\Elo\EloHandler;
use App\Handler\Unranked\UnrankedHandler;
use DateTime;

class ClientAndLenderHandler extends BaseHandler
{
    private $unrankedHandler;
    private $eloHandler;
    
    public function __construct(UnrankedHandler $unrankedHandler, EloHandler $eloHandler){
        $this->unrankedHandler = $unrankedHandler;
        $this->eloHandler = $eloHandler;
    }

    // No hay servicio create. Sólo se lo crea desde user.
    public function create(Client $client = null, Lender $lender = null){
        $em                = $this->getEm();
        $clientAndLender   = new ClientAndLender();

        $clientAndLender   = $this->setter($clientAndLender, $client, $lender);
        $validate          = $this->validateFields($clientAndLender);
        if($validate){
            $this->unrankedHandler->create($clientAndLender);
            $this->eloHandler->create($clientAndLender);
            $em->persist($clientAndLender);
            $em->flush();
            return $clientAndLender;
        }else{
            throw new \Exception($validate);
        }
    }

    public function update($params){
        $em                  = $this->getEm();
        $clientAndLender     = $this->getRepo('ClientAndLender')->find($params['clientAndLenderId']);
        if(!is_null($clientAndLender)){
            $clientAndLender = $this->paramsSetter($clientAndLender, $params);
            $validate        = $this->validateFields($clientAndLender);
            if($validate){
                $em->flush();
                return $clientAndLender;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The ClientAndLender isn't exists with id " . $params["clientAndLenderId"]);
        }
    }

    private function setter(ClientAndLender $clientAndLender, $client, $lender){
        if(!is_null($client)){
            $clientAndLender->setClient($client);
        }
        if(!is_null($lender)){
            $clientAndLender->setLender($lender);
        }
        return $clientAndLender;
    }

    private function paramsSetter(ClientAndLender $clientAndLender, $params){
        $clientAndLender->setCountServicesTotal($params['countServicesTotal']);
        return $clientAndLender;
    }

    private function validateFields(ClientAndLender $rol){
        return true;
    }
}

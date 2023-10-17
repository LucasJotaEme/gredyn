<?php

namespace App\Handler\Client;

use App\Base\BaseHandler;
use App\Entity\Client;
use App\Entity\User;
use App\Handler\ClientAndLender\ClientAndLenderHandler;
use DateTime;

class ClientHandler extends BaseHandler
{
    private $clientAndlenderHandler;
    
    public function __construct(ClientAndLenderHandler $clientAndlenderHandler){
        $this->clientAndlenderHandler = $clientAndlenderHandler;
    }
    // No hay servicio create. Sólo se lo crea desde user.
    public function create(User $user){
        $em       = $this->getEm();
        $client   = new Client();
        $client   = $this->setter($client, $user);
        $validate = $this->validateFields($client);
        if($validate){
            $this->clientAndlenderHandler->create($client);
            $em->persist($client);
            $em->flush();
            return $client;
        }else{
            throw new \Exception($validate);
        }
    }

    public function update($params){
        $em                  = $this->getEm();
        $client              = $this->getRepo('Client')->find($params['clientId']);
        if(!is_null($client)){
            $client       = $this->paramsSetter($client, $params);
            $validate     = $this->validateFields($client);
            if($validate){
                $em->flush();
                return $client;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The Client isn't exists with id " . $params["clientId"]);
        }
    }

    public function delete($id){
        $em      = $this->getEm();
        $client  = $this->getRepo('Client')->find($id);
        if(!is_null($client)){
            $em->remove($client);
            $em->flush();
        }else{
            throw new \Exception("The client isn't exist");
        }
    }

    private function setter(Client $client, User $user){
        $client->setUser($user);
        return $client;
    }

    private function paramsSetter(Client $client, $params){
        // $p->setLenderStatus($params['lenderStatus']);
        // $lender->setDescription($params['description']);
        return $client;
    }

    private function validateFields(Client $rol){
        return true;
    }
}

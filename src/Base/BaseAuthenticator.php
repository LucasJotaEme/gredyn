<?php

namespace App\Base;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
use DateTime;

class BaseAuthenticator extends AbstractController
{
    public function validateLogin($userName, $password){
        $response = $this->prepareMethodsResponse();
        $user = $this->getRepo('User')->findOneBy(array('userName'=> $userName));
        if(!is_null($user)){
            if(password_verify($password, $user->getPassword())){
                $apiToken = $this->generateToken();
                $user->setToken($apiToken);
                $user->setLastSession(new \DateTime());
                $this->getEm()->flush();
                $response["result"] = $apiToken;
                return $response;
            }else{
                $response["error"] = "Invalid passowrd";
                return $response;
            }
        }else{
            $response["error"] = "User not found";
            return $response;
        }
    }

    public function generateToken(){
        $token = sha1(mt_rand(1, 90000) . 'SALT');
        return $token;
    }

    public function getEm(){
        return $this->getDoctrine()->getManager();
    }

    public function getRepo($repositoryName){
        $routeEntity = $this->getParameter("entity");
        $repository  = $this->getDoctrine()->getRepository($routeEntity . ucfirst($repositoryName));
        return $repository;
    }

    public function getParam($param){
        return $this->getParameter($param);
    }

    public function validateSessionDate($user){
        $response          = $this->prepareMethodsResponse();
        $lastSession       = $user->getLastSession();
        $timeLimit         = $this->getParam('time_session_limit');
        $currentDate       = new \DateTime();
        $currentDateModify = new \DateTime();
        $waitLimit         = $currentDateModify->modify("-$timeLimit");
        if(!is_null($lastSession) && $waitLimit > $lastSession ){
            $user->setToken("");
            $response["error"] = "the token have expired";
        }else{
            $user->setLastSession($currentDate);
        }
        $this->getEm()->flush();
        $response["result"] = $user;
        return $response;
    }

    public function updateLastSession($user){
        $user->setLastSession(new \DateTime());
        $this->getEm()->flush();
        return $user;
    }

    private function prepareMethodsResponse(){
        return array(
            "result" => null,
            "info"   => null,
            "error"  => null
            );
    }
}

<?php

namespace App\Base;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseHandler extends AbstractController
{

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
}
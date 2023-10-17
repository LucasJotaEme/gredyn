<?php

namespace App\Handler\Service;

use App\Base\BaseHandler;
use App\Entity\Service;
use DateTime;

class ServiceHandler extends BaseHandler
{

    public function create($params){
        $em               = $this->getEm();
        $service          = new Service();
        $service          = $this->setter($service, $params);
        // $readyExist       = $this->getRepo('Service')->findOneBy(array('ClientAndLender' => $category->getName()));
        $readyExist       = null;
        if(is_null($readyExist)){
            $validate = $this->validateFields($service);
            if($validate){
                $em->persist($service);
                $em->flush();
                return $service;
            }else{
                throw new \Exception($validate);
            }
        }else{
            // throw new \Exception("Category with name " . $category->getName() .  " already exists");
        }
    }

    public function update($params){
        $em               = $this->getEm();
        $service          = $this->getRepo('Service')->find($params['serviceId']);
        if(!is_null($service)){
            $service     = $this->setter($service, $params);
            $validate     = $this->validateFields($service);
            if($validate){
                $em->flush();
                return $service;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The service not exists with id " . $params["serviceId"]);
        }
    }

    public function delete($id){
        $em   = $this->getEm();
        $service  = $this->getRepo('Service')->find($id);
        if(!is_null($service)){
            $em->remove($service);
            $em->flush();
        }else{
            throw new \Exception("The service not exists");
        }
    }

    public function addClientsAndLenders($content){
        $em               = $this->getEm();
        $category         = $this->getRepo('Category')->find($content->categoryId);
        if(!is_null($category)){
            foreach($content->clientsAndLenders as $contentClientAndLender){
                $clientAndLender     = $this->getRepo('ClientAndLender')->find($contentClientAndLender->id);
                if(!is_null($clientAndLender)){
                    $category->addClientAndLender($clientAndLender);
                }else{
                    throw new \Exception("The category with id " . $contentClientAndLender->id . " was not found");
                }
            }
            $em->flush();
            return $category;
        }else{
            throw new \Exception("There is not a category with id " . $content->categoryId);
        }
    }

    public function removeClientsAndLenders($content){
        $em               = $this->getEm();
        $category         = $this->getRepo('Category')->find($content->categoryId);
        if(!is_null($category)){
            foreach($content->clientsAndLenders as $contentClientAndLender){
                $clientAndLender     = $this->getRepo('ClientAndLender')->find($contentClientAndLender->id);
                if(!is_null($clientAndLender)){
                    $category->removeClientAndLender($clientAndLender);
                }else{
                    throw new \Exception("The clientAndLender with id " . $contentClientAndLender->id . " was not found");        
                }
            }
            $em->flush();
            return $category;
        }else{
            throw new \Exception("There is not a category with id " . $content->categoryId);
        }
    }

    private function setter(Service $service, $params){
        if(isset($params["status"])){
            $service->setStatus($params["status"]);
        }
        if(isset($params["clientAndLenderId"])){
            $clientAndLender = $this->getRepo('ClientAndLender')->find($params["clientAndLenderId"]);
            $service->setClientAndLender($clientAndLender);
            $service->setCreated(new \DateTime());
        }
        if(isset($params["categoryId"])){
            $category = $this->getRepo('Category')->find($params["categoryId"]);
            $service->setCategory($category);
        }
        return $service;
    }

    private function validateFields(Service $service){
        return true;
    }
}

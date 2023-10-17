<?php

namespace App\Handler\Category;

use App\Base\BaseHandler;
use App\Entity\CategoryType;
use App\Entity\Rol;
use DateTime;

class CategoryTypeHandler extends BaseHandler
{

    public function create($params){
        $em               = $this->getEm();
        $categoryType     = new CategoryType();
        $categoryType     = $this->setter($categoryType, $params);
        $readyExist       = $this->getRepo('CategoryType')->findOneBy(array('name' => $categoryType->getName()));
        if(is_null($readyExist)){
            $validate = $this->validateFields($categoryType);
            if($validate){
                $em->persist($categoryType);
                $em->flush();
                return $categoryType;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("CategoryType with name " . $categoryType->getName() .  " already exists");
        }
    }

    public function update($params){
        $em               = $this->getEm();
        $categoryType     = $this->getRepo('CategoryType')->find($params['categoryTypeId']);
        if(!is_null($categoryType)){
            $categoryType = $this->setter($categoryType, $params);
            $validate     = $this->validateFields($categoryType);
            if($validate){
                $em->flush();
                return $categoryType;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The CategoryType not exists with name " . $params["name"]);
        }
    }

    public function delete($id){
        $em            = $this->getEm();
        $categoryType  = $this->getRepo('CategoryType')->find($id);
        if(!is_null($categoryType)){
            $em->remove($categoryType);
            $em->flush();
        }else{
            throw new \Exception("The CategoryType not exists");
        }
    }

    public function addClientsAndLenders($content){
        $em               = $this->getEm();
        $categoryType         = $this->getRepo('CategoryType')->find($content->categoryTypeId);
        if(!is_null($categoryType)){
            foreach($content->clientsAndLenders as $contentClientAndLender){
                $clientAndLender     = $this->getRepo('ClientAndLender')->find($contentClientAndLender->id);
                if(!is_null($clientAndLender)){
                    $categoryType->addClientAndLender($clientAndLender);
                }else{
                    throw new \Exception("The categoryType with id " . $contentClientAndLender->id . " was not found");
                }
            }
            $em->flush();
            return $categoryType;
        }else{
            throw new \Exception("There is not a categoryType with id " . $content->categoryTypeId);
        }
    }

    public function removeClientsAndLenders($content){
        $em               = $this->getEm();
        $categoryType         = $this->getRepo('CategoryType')->find($content->categoryTypeId);
        if(!is_null($categoryType)){
            foreach($content->clientsAndLenders as $contentClientAndLender){
                $clientAndLender     = $this->getRepo('ClientAndLender')->find($contentClientAndLender->id);
                if(!is_null($clientAndLender)){
                    $categoryType->removeClientAndLender($clientAndLender);
                }else{
                    throw new \Exception("The clientAndLender with id " . $contentClientAndLender->id . " was not found");        
                }
            }
            $em->flush();
            return $categoryType;
        }else{
            throw new \Exception("There is not a categoryType with id " . $content->categoryTypeId);
        }
    }

    private function setter(CategoryType $categoryType, $params){
        if(isset($params["categoryId"])){
            $category = $this->getRepo('Category')->find($params["categoryId"]);
            if(!is_null($category)){
                $categoryType->setCategory($category);
            }else{
                throw new \Exception("Trying join categoryType with category that not exists");
            }
        }
        if(isset($params["type"])){
            $categoryType->setType($params["type"]);
        }
        if(isset($params["name"])){
            $categoryType->setName($params["name"]);
        }
        if(isset($params["price"])){
            $categoryType->setPrice($params["price"]);
        }
        return $categoryType;
    }

    private function validateFields(CategoryType $categoryType){
        return true;
    }
}

<?php

namespace App\Handler\Category;

use App\Base\BaseHandler;
use App\Entity\Category;
use App\Entity\Rol;
use DateTime;

class CategoryHandler extends BaseHandler
{

    public function create($params){
        $em               = $this->getEm();
        $category         = new Category();
        $category         = $this->setter($category, $params);
        $readyExist       = $this->getRepo('Category')->findOneBy(array('name' => $category->getName()));
        if(is_null($readyExist)){
            $validate = $this->validateFields($category);
            if($validate){
                $em->persist($category);
                $em->flush();
                return $category;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("Category with name " . $category->getName() .  " already exists");
        }
    }

    public function update($params){
        $em               = $this->getEm();
        $category         = $this->getRepo('Category')->find($params['categoryId']);
        if(!is_null($category)){
            $category     = $this->setter($category, $params);
            $validate     = $this->validateFields($category);
            if($validate){
                $em->flush();
                return $category;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The Category not exists with name " . $params["name"]);
        }
    }

    public function delete($id){
        $em   = $this->getEm();
        $category  = $this->getRepo('Category')->find($id);
        if(!is_null($category)){
            $em->remove($category);
            $em->flush();
        }else{
            throw new \Exception("The Category not exists");
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

    private function setter(Category $category, $params){
        if(isset($params["name"])){
            $category->setName($params["name"]);
        }
        if(isset($params["price"])){
            $category->setPrice($params["price"]);
        }
        if(isset($params["totalPrice"])){
            $category->setTotalPrice($params["totalPrice"]);
        }
        if(isset($params["starRating"])){
            $category->setStarRating($params["starRating"]);
        }
        if(isset($params["photo"])){
            // $category->setStarRating($params["photo"]);
        }
        return $category;
    }

    private function validateFields(Category $category){
        return true;
    }
}

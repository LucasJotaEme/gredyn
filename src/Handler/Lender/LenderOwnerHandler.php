<?php

namespace App\Handler\Lender;

use App\Base\BaseHandler;
use App\Entity\Lender;
use App\Entity\LenderOwner;
use App\Entity\User;
use DateTime;

class LenderOwnerHandler extends BaseHandler
{

    public function convertOwner($lenderId){
        $em                    = $this->getEm();
        $lenderOwner           = new LenderOwner();
        $lender                = $this->getRepo('Lender')->find($lenderId);
        if(!is_null($lender)){
            $lenderOwner       = $this->setter($lender, $lenderOwner);
            $validate          = $this->validateFields($lenderOwner);
            if($validate){
                $em->persist($lenderOwner);
                $em->flush();
                return $lender;
            }else{
                throw new \Exception($validate);
            }
        }else{
            throw new \Exception("The Lender isn't exists with id $lenderId");
        }
    }

    public function unconvertOwner($lenderId){
        $em                    = $this->getEm();
        $lender                = $this->getRepo('Lender')->find($lenderId);
        if(!is_null($lender)){
            $lenderOwner       = $this->getRepo('LenderOwner')->findOneBy(array("lender" => $lender));
            if(!is_null($lender)){
                $em->remove($lenderOwner);
                $em->flush();
                return $lender;
            }else{
                throw new \Exception("The Lender is not a LenderOwner");
            }
        }else{
            throw new \Exception("The Lender isn't exists with id $lenderId");
        }
    }

    private function setter(Lender $lender, LenderOwner $lenderOwner){
        $lenderOwner->setLender($lender);
        return $lenderOwner;
    }

    private function validateFields(LenderOwner $lenderOwner){
        return true;
    }
}

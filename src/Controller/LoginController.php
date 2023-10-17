<?php

namespace App\Controller;

use App\Handler\User\UserHandler;
use App\Base\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends BaseController
{
    private $userHandler;

    public function __construct(UserHandler $userHandler){
        $this->userHandler = $userHandler;
    }

    /**
     * @Route("/login"),
     * methods={"POST"},
     * params = {user, password}
    */
    public function login(Request $request){
        $user = $this->getUser();
        if(!is_null($user) && !is_null($token = $user->getToken())){
            return $this->createResultResponse($token);
        }else{
            return $this->createErrorResponse("Not generated a token. Try again");
        }
    }
}


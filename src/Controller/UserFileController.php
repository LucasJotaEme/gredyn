<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Handler\User\UserFileHandler;
use App\Base\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\DependencyInjection\ContainerInterface;


class UserFileController extends BaseController
{
    private $userFileHandler;

    public function __construct(UserFileHandler $userFileHandler){
        $this->userFileHandler = $userFileHandler;
    }
}


<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use App\Base\BaseAuthenticator;
use DateTime;

class UserAuthenticator extends AbstractAuthenticator
{
    public function __construct(BaseAuthenticator $baseAuthenticator)
    {
        $this->baseAuthenticator = $baseAuthenticator;
    }

    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request)
    {
        $apiToken = $request->headers->get('apiToken');
        $user     = $request->request->get('userName');
        $password = $request->request->get('password');

        if(null === $apiToken){
            if(strpos($request->attributes->get("_route"), "login") !== false && !is_null($user) && !is_null($password)){
                $res  = $this->baseAuthenticator->validateLogin($user, $password);
                if(is_null($res["error"])){
                    $apiToken = $res["result"];
                }else{
                    throw new CustomUserMessageAuthenticationException($res["error"]);        
                }
            }else{
                throw new CustomUserMessageAuthenticationException('No API token provided or invalid credentials');    
            }
        }else{
            if(strpos($request->attributes->get("_route"), "login") !== false){
                throw new CustomUserMessageAuthenticationException("login service don't must have apiToken");    
            }else{
                $user = $this->baseAuthenticator->getRepo('User')->findOneBy(array('token' => $apiToken));
                if($apiToken != "" && !is_null($user)){
                    if(!$user->getRemindMe()){
                        $res = $this->baseAuthenticator->validateSessionDate($user);
                        if(!is_null($res["error"])){
                            throw new CustomUserMessageAuthenticationException($res["error"]);
                        }
                    }else{
                        $this->baseAuthenticator->updateLastSession($user);
                    }
                }else{
                    throw new CustomUserMessageAuthenticationException("apiToken no valid");
                }
            }
        }
        return new SelfValidatingPassport(new UserBadge($apiToken));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

   public function start(Request $request, AuthenticationException $authException = null): Response
   {
       $response = new Response();
       return $response;
       /*
        * If you would like this class to control what happens when an anonymous user accesses a
        * protected page (e.g. redirect to /login), uncomment this method and make this class
        * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
        *
        * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
        */
   }
}

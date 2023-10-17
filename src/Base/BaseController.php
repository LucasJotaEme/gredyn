<?php

namespace App\Base;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Serializer;

class BaseController extends AbstractController
{
    /* 
        Prepara la forma en que respondemos en todos los servicios.
        result = Respuesta json,
        error  = Error en string,
        info   = Información extra de result.
    */
    public function createResultResponse($result, $info = null){
        $response = new JsonResponse();
        $response->setData([
            "result" => $result,
            "error"  => null,
            "info"   => $info
        ]);
        return $response;
    }

    /* 
        Prepara la forma en que respondemos en todos los servicios.
        result = Respuesta json,
        error  = Error en string,
        info   = Información extra de result.
    */
    public function createErrorResponse($error){
        $response = new JsonResponse();
        $response->setData([
            "result" => null,
            "error"  => $error,
            "info"   => null
        ]);
        return $response;
    }

    /* 
    *   Convierta cualquier entidad a JSON.
    */
    public function serializer($entity, Array $subEntities = array()){
        $encoders    = [new XmlEncoder(), new JsonEncoder()];
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($subEntities, $format, $context) {
                return $subEntities;
            },
        ];
        $normalizers = [new ObjectNormalizer(null, null, null, null, null, null, $defaultContext)];
        $serializer   = new Serializer($normalizers, $encoders);
        return json_decode($serializer->serialize($entity, 'json'));
    }

    /* 
    *   Recibe la Request y con los parámetros que son obligatorios.
        Responde error si no están completos.
    */
    public function getParams(Array $params, Request $request){
        $response       = $this->prepareMethodsResponse();
        $arrayParams    = $request->request->all();
        $filesParams    = $request->files->all();
        $paramsNotFound = array();
        foreach($params as $param){
            if(!array_key_exists($param, $arrayParams) && !array_key_exists($param, $filesParams)){
                $paramsNotFound[] = $param;
            }
        }
        if(empty($paramsNotFound)){
            if(empty($filesParams)){
                $response["result"] = $arrayParams;
                return $response;
            }else{
                foreach($filesParams as $key => $file){
                    $arrayParams["files"][$key] = $file;
                }
                $response["result"] = $arrayParams;
                return $response;
            }
        }else{
            $response["error"] = $paramsNotFound;
            return $response;
        }
    }

    /* 
    *   Recibe la Request para buscar el content y convertirlo en array.
        Responde error si no se encuentran los params solicitados.
    */
    public function getRequestContent(Array $params, Request $request){
        $res = $this->prepareMethodsResponse();
        // For return
        $objectContent   = json_decode($request->getContent());
        // For validations
        $arrayContent    = json_decode($request->getContent(), true);
        if(is_null($objectContent)){
            $res["error"] = array("Not content");
            return $res;
        }
        foreach($params as $param){
            if(!array_key_exists($param, $arrayContent)){
                $paramsNotFound[] = $param;
            }
        }
        if(!empty($paramsNotFound)){
            $res["error"] = $paramsNotFound;
            return $res;
        }else{
            $res["result"] = $objectContent;
            return $res;
        }
    }

    private function prepareMethodsResponse(){
        return array(
            "result" => null,
            "info"   => null,
            "error"  => null
            );
    }
}
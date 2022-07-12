<?php
namespace App\EventListener;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionListener
{

    public function onKernelException(ExceptionEvent $event) : void
    {
        if ($event->getThrowable() instanceof NotFoundHttpException || $event->getThrowable() instanceof MethodNotAllowedHttpException )
        {
           if(method_exists($event->getThrowable(),'getCode') && $event->getThrowable()->getCode() != 0)
           {
               $code= $event->getThrowable()->getCode();
           }
           else
           {
               $code= $event->getThrowable()->getStatusCode();
           }
            $response['message']=$event->getThrowable()->getMessage();
            $response['code']=$code;
            $event->setResponse(new JsonResponse($response,$code));
        }
    }
}

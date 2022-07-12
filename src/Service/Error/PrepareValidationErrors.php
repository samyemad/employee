<?php
namespace App\Service\Error;

use App\Service\Interfaces\PrepareErrorsInterface;
use App\Service\Interfaces\ProcessFormErrorsInterface;
use Symfony\Component\Form\FormInterface;

class PrepareValidationErrors implements PrepareErrorsInterface
{

    /**
     * prepare validation errors message
     * @param array $errors
     * @return array
     */
    public function process(array $errors): array
    {
        $response=[];
        if(!empty($errors))
        {
            $response['message']='Validation Required';
            $response['code']=400;
            $response['errors']=$errors;
        }
        return $response;

    }
}


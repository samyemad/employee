<?php
namespace App\Service\Error;

use App\Service\Interfaces\PrepareErrorsInterface;
use App\Service\Interfaces\ProcessFormErrorsInterface;
use Symfony\Component\Form\FormInterface;

class ProcessFormErrors implements ProcessFormErrorsInterface
{
    private PrepareErrorsInterface $prepareValidationErrors;

    public function __construct(
        PrepareErrorsInterface $prepareValidationErrors
    )
    {
        $this->prepareValidationErrors = $prepareValidationErrors;
    }

    /**
     * prepare form errors response and pass it to validation errors to custom these errors
     * @param FormInterface $errors
     * @return array
     */
    public function process(FormInterface $form): array
    {
        $errors=[];
        $formErrors=$form->getErrors(true, true);
        foreach ($formErrors as $error)
        {
            if($error->getOrigin() != null && $error->getOrigin()->getConfig()->getName())
            {
                $paramName=$error->getOrigin()->getConfig()->getName();
                $errors[$paramName]['message'] = $error->getMessage();
                $errors[$paramName]['origin']= $error->getMessageParameters();
            }
        }
        $result=$this->prepareValidationErrors->process($errors);
        return $result;
    }
}


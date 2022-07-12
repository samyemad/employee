<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Employee;
use App\Service\Interfaces\ActionInterface;
use App\Service\Interfaces\ProcessFormErrorsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use App\Form\EmployeeType;
use App\Service\Interfaces\SnakeCaseToCamelCaseHandlerInterface;

final class EmployeeController extends AbstractController
{
    private SnakeCaseToCamelCaseHandlerInterface $snakeCaseToCamelCaseHandler;

    public function __construct(
        SnakeCaseToCamelCaseHandlerInterface $snakeCaseToCamelCaseHandler
    )
    {
        $this->snakeCaseToCamelCaseHandler = $snakeCaseToCamelCaseHandler;
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/employee/{identifier}", name="get_employee", methods={"GET"})
     * @Entity("employee", expr="repository.findOneByIdentifier(identifier)")
     * @param Employee $employee
     * @return Response
     */
    public function getEmployee(Employee $employee,ActionInterface $showEmployeeAction): Response
    {
        $content=$showEmployeeAction->process($employee);
        return new Response(json_encode($content), Response::HTTP_OK, [
            'Content-Type' => 'application/json',
        ]);
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/employees", name="get_employees", methods={"GET"})
     * @return Response
     */
    public function getEmployees(ActionInterface $showAllEmployeesAction): Response
    {
        $content=$showAllEmployeesAction->process(null);
        return $this->json($content,Response::HTTP_OK);
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/employees", name="save_employees", methods={"POST"})
     * @return Response
     */
    public function createEmployee(
        Request $request,
        ActionInterface $createEmployeeAction,
        ProcessFormErrorsInterface $processFormErrors,
        ActionInterface $denormalizeCreateEmployeeAction
    ) {
        $data=$this->snakeCaseToCamelCaseHandler->process($request->getContent());
        $result=$denormalizeCreateEmployeeAction->process($data);
        if(!$result instanceof Employee)
        {
            return $this->json($result,$result['code']);
        }
        $form=$this->createForm(EmployeeType::class,$result);
        $form->submit($data);
        if($form->isSubmitted() && $form->isValid())
        {
            $content=$createEmployeeAction->process([$result]);
            return $this->json($content,Response::HTTP_CREATED);
        }
        else
        {
            $formErrors=$processFormErrors->process($form);
            return $this->json($formErrors,Response::HTTP_BAD_REQUEST);
        }
      }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/employee/{identifier}", name="update_employee", methods={"PUT"})
     * @Entity("employee", expr="repository.findOneByIdentifier(identifier)")
     * @param Employee $employee
     * @return Response
     */
    public function updateEmployee(
        Employee $employee,
        Request $request,
        ActionInterface $updateEmployeeAction,
        ProcessFormErrorsInterface $processFormErrors
    ): Response
    {
        $data=$this->snakeCaseToCamelCaseHandler->process($request->getContent());
        $form=$this->createForm(EmployeeType::class,$employee);
        $currentYouweTeams=$employee->getYouweTeams();
        $form->submit($data);
        if($form->isSubmitted() && $form->isValid())
        {
            $params=[$employee,$currentYouweTeams];
            $updateEmployeeAction->process($params);
            return $this->json('',Response::HTTP_NO_CONTENT);
        }
        else
        {
            $response=$processFormErrors->process($form);
            return $this->json($response,Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/employee/{identifier}", name="delete_employee", methods={"DELETE"})
     * @Entity("employee", expr="repository.findOneByIdentifier(identifier)")
     * @param Employee $employee
     * @return Response
     */
    public function deleteEmployee(Employee $employee,ActionInterface $deleteEmployeeAction): Response
    {
        $deleteEmployeeAction->process($employee);
        return $this->json('',Response::HTTP_NO_CONTENT);
    }

}
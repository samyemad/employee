<?php

namespace App\Tests\Controller;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Tests\ApiTestCase;

class EmployeeControllerTest extends ApiTestCase
{
    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->token=$this->getUserToken();
        $this->browser->setServerParameter('HTTP_AUTHORIZATION','Bearer '.$this->token);

    }

    public function testShowSingleEmployee()
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/get_single_employee.yaml',
        ]);

        $this->browser->jsonRequest('GET', '/employee/ed2ec84a-be93-4975-9c1c-8f9a838eb49f',[],
        );
        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function testShowAllEmployees()
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/get_all_employees.yaml',
        ]);
        $this->browser->jsonRequest('GET', '/employees');
        static::assertResponseIsSuccessful();
        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->token);
    }


}
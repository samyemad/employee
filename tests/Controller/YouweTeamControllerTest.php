<?php

namespace App\Tests\Controller;

use App\Tests\ApiTestCase;

class YouweTeamControllerTest extends ApiTestCase
{

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->token=$this->getUserToken();
        $this->browser->setServerParameter('HTTP_AUTHORIZATION','Bearer '.$this->token);

    }
    public function testShowSingleYouweTeam()
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/get_single_youwe_team.yaml',

        ]);
        $this->browser->request('GET', '/youwe_team/bd2f440e-8fa9-4db9-aa5c-f210ea816900');

        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function testShowAllYouweTeams()
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/get_all_youwe_teams.yaml',
        ]);
        $this->browser->request('GET', '/youwe_teams');

        static::assertResponseIsSuccessful();

        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function testShowEmployeesUnderASingleYouweTeam()
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/get_employees_under_single_youwe_team.yaml',
            __DIR__.'/fixtures/get_single_employee.yaml',
        ]);
        $this->browser->request('GET', '/youwe_team/122ffa9e-3439-414b-be8a-5abd3f05007c');
        static::assertResponseIsSuccessful();
        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    /**
     * @dataProvider paginationQueryParameterValues
     */
    public function testShowPaginatedYouweTeams(int $page, int $size): void
    {
        $this->loadFixtures([
            __DIR__.'/fixtures/get_pagination_youwe_teams.yaml',
        ]);
        $this->browser->request('GET', sprintf('/youwe_teams?page=%d&size=%d', $page, $size));
        static::assertResponseIsSuccessful();
        $this->assertMatchesJsonSnapshot($this->browser->getResponse()->getContent());
    }

    public function paginationQueryParameterValues(): \Generator
    {
        yield 'page 1, 3 objects' => [1, 3];
        yield 'page 2, 3 objects' => [2, 3];
        yield 'page 1, 5 objects' => [1, 5];
        yield 'page 2, 5 objects' => [2, 5];
    }

    public function tearDown(): void
    {
        parent::tearDown();
        unset($this->token);
    }



}
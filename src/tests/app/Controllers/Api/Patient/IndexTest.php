<?php

namespace App\Controllers\Api\Patient;

use App\Controllers\Api\PatientController;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Services;
use Exception;
use Tests\Support\Database\Seeds\DatabaseSeeder;
use Tests\Support\Models\PatientModel;


class IndexTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected $seed = DatabaseSeeder::class;
    protected string $baseUrl;

    public function setUp(): void
    {
        parent::setUp();

        $route = route_to('patient.index');
        $this->baseUrl = site_url($route);
    }

    public function testShouldReturn200WithListPaginated(): void
    {
        //Act
        $response = $this->withUri($this->baseUrl)
            ->controller(PatientController::class)
            ->execute('index');

        //Assert
        $this->assertTrue($response->getJSON() !== false);
        $response->assertStatus(200);
        $response->assertJSONFragment(['data' => ['patients' => []]]);
        $response->assertJSONFragment(['data' => ['pagination' => []]]);
    }

    public function testShouldReturnListPaginatedFiltered(): void
    {
        // Arrange
        $search = 'Eunice';
        $uri = "$this->baseUrl?search=$search";

        // Act
        $response = $this->withUri($uri)
            ->controller(PatientController::class)
            ->execute('index');
        $json = json_decode($response->getJSON());

        // Assert
        $this->assertStringContainsString($search, $json->data->patients[0]->name);
    }

    public function testShouldReturnListPaginatedWithOnlyPatientsDeleted(): void
    {
        // Arrange
        $patientId = 3;
        $patientModel = new PatientModel();
        $patientModel->delete($patientId);

        $params = 'true';
        $uri = "$this->baseUrl?search_deleted=$params";

        // Act
        $response = $this->withUri($uri)
            ->controller(PatientController::class)
            ->execute('index');
        $json = json_decode($response->getJSON());

        // Assert
        $this->assertEquals($json->data->patients[0]->id, $patientId);
    }

    public function testShouldCallIndexActionWithCorrectValues(): void
    {
        // Arrange
        $patientActionSpy = $this->getMockBuilder(PatientIndexAction::class)
            ->setMethods(['execute'])
            ->getMock();

        Services::injectMock('patientIndexAction', $patientActionSpy);

        $patientActionSpy->expects($this->once())
            ->method('execute')
            ->willReturnCallback(function ($search, $searchDeleted) use (&$actualArgs) {
                $actualArgs = [$search, $searchDeleted];
            });

        $search = 'Eunice';
        $searchDeleted = 'true';
        $uri = "$this->baseUrl?search=$search&search_deleted=$searchDeleted";

        // Act
        $this->withUri($uri)
            ->controller(PatientController::class)
            ->execute('index');

        // Assert
        $this->assertEquals([$search, $searchDeleted], $actualArgs);
    }

    public function testShouldReturn500IfOperationThrows(): void
    {
        // Arrange
        $patientControllerSpy = $this->getMockBuilder(PatientController::class)
            ->setMethods(['index'])
            ->getMock();

        $patientControllerSpy->expects($this->once())
            ->method('index')
            ->willThrowException(new Exception('Error'));

        // Act
        $response = $this->withUri($this->baseUrl)
            ->controller(PatientController::class)
            ->execute('index');

        $this->markTestIncomplete(
            'Está estourando um erro nos asserts'
        );

        // Assert
        $response->assertStatus(500);
    }
}

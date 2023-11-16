<?php

namespace App\Controllers\Api\Patient;

use App\Controllers\Api\PatientController;
use App\Dtos\Patient\PatientStoreDTO;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Config\Services;
use Exception;
use Mockery;
use Tests\Support\Database\Seeds\DatabaseSeeder;

class StoreTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected $seed = DatabaseSeeder::class;
    protected IncomingRequest $requestConfig;
    protected string $baseUrl;
    protected array $bodyData;
    protected array $addressData;
    protected array $patientData;

    public function setUp(): void
    {
        parent::setUp();

        helper('custom');

        $route = route_to('patient.store');
        $this->baseUrl = site_url($route);

        $this->patientData = [
            "name" => "Any User Name",
            "mother_name" => "Any User Mother Name.",
            "birth_date" => "1999-04-24",
            "cpf" => "01655807552",
            "cns" => "859931486960009"
        ];

        $this->addressData = [
            "zip_code" => "09351330",
            "street" => "Rua Nevada",
            "number" => "100",
            "complement" => "A",
            "neighborhood" => "Bandeirantes",
            "city" => "Mauá",
            "state_id" => "25"
        ];

        $this->bodyData = [
            ...$this->patientData,
            ...$this->addressData
        ];

        $this->requestConfig = new \CodeIgniter\HTTP\IncomingRequest(
            new \Config\App(),
            new \CodeIgniter\HTTP\URI($this->baseUrl),
            null,
            new \CodeIgniter\HTTP\UserAgent()
        );

        $this->requestConfig->setHeader('Content-Type', 'application/json');
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }

    public function testShouldReturn201IfSuccess(): void
    {
        //Act
        $response = $this->withRequest($this->requestConfig)
            ->withBody(json_encode($this->bodyData))
            ->controller(PatientController::class)
            ->execute('store');

        //Assert
        $response->assertStatus(201);
        $this->seeInDatabase('patients', $this->patientData);
        $this->seeInDatabase('addresses', $this->addressData);
    }

    public function testShouldCallPatientStoreDTOWithCorrectValues()
    {
        // Arrange
        $patientStoreDTOSpy = Mockery::mock(PatientStoreDTO::class);

        // Act
        $this->withRequest($this->requestConfig)
            ->withBody(json_encode($this->bodyData))
            ->controller(PatientController::class)
            ->execute('store');

        $this->markTestIncomplete(
            'Não estou conseguindo mockar o método estático'
        );

        // Assert
        $patientStoreDTOSpy->shouldReceive('make')
            ->withArgs($this->bodyData)
            ->once();
        $this->assertTrue(true);
    }

    public function testShouldCallStoreActionCorrectValues()
    {
        // Arrange
        $patientActionSpy = $this->getMockBuilder(PatientStoreAction::class)
            ->setMethods(['execute'])
            ->getMock();

        Services::injectMock('patientStoreAction', $patientActionSpy);

        $DtoData = [
            ...$this->bodyData,
            'image' => null
        ];

        $PatientStoreDTOInstance = PatientStoreDTO::make($DtoData);

        $patientActionSpy->expects($this->once())
            ->method('execute')
            ->with($this->equalTo($PatientStoreDTOInstance));

        // Act
        $this->withRequest($this->requestConfig)
            ->withBody(json_encode($this->bodyData))
            ->controller(PatientController::class)
            ->execute('store');
    }

    public function testShouldReturn500IfOperationThrows()
    {
        // Arrange
        $patientControllerSpy = $this->getMockBuilder(PatientController::class)
            ->setMethods(['store'])
            ->getMock();

        $patientControllerSpy->expects($this->once())
            ->method('store')
            ->willThrowException(new Exception('Error', 500));

        // Act
        $response = $this->withRequest($this->requestConfig)
            ->withBody(json_encode($this->bodyData))
            ->controller(PatientController::class)
            ->execute('store');

        $this->markTestIncomplete(
            'Não está mockando o retorno'
        );

        // Assert
        $response->assertStatus(500);
    }

    public function testShouldReturn422IfValidationFails(): void
    {
        // Arrange
        unset($this->bodyData['name']);

        // Act
        $response = $this->withRequest($this->requestConfig)
            ->withBody(json_encode($this->bodyData))
            ->controller(PatientController::class)
            ->execute('store');

        // Assert
        $response->assertStatus(422);
    }
}

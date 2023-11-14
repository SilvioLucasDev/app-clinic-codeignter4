<?php

namespace App\Controllers;

use App\Controllers\Api\PatientController;
use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;
use Tests\Support\Database\Seeds\DatabaseSeeder;

class PatientControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait;
    use DatabaseTestTrait;

    protected $seed = DatabaseSeeder::class;

    public function testIndexMethod()
    {
        $result = $this->withURI('/patient')
            ->controller(PatientController::class)
            ->execute('index');

        dd($result);

        $this->assertTrue($result->isOK());
    }

    public function testShouldReturnListPaginated()
    {
        // $result = $this->controller(PatientController::class)
        //     ->execute('index');

        // dd($result);
        // $this->assertTrue($result->isOK());
    }

    public function testShouldReturnListPaginatedFiltered()
    {
        // ...
    }

    public function testShouldReturnListPaginatedWithOnlyPatientsDeleted()
    {
        // ...
    }

    public function testShouldReturnOperationErrorIfThrows()
    {
        // ...
    }
}

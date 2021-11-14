<?php

namespace Tests\Feature;

//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
//use PHPUnit\Framework\TestCase;

class CompanyTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('http://127.0.0.1:8000/api/company');

        $response->assertStatus(200);
    }

    public function test_company_exist(){
        $this->assertDatabaseHas('companies',[
            'name' => 'Test Company A'
        ]);
    }
}

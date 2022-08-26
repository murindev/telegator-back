<?php

namespace Tests\Feature;

namespace Tests\Feature;

use App\Http\Requests\Auth\RegistryRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Str;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @var \App\Http\Requests\Auth\LoginRequest */
    private $rules;
    /** @var \Illuminate\Validation\Validator */
    private $validator;
    private $user;
    public $userPassword;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
//        $aws = config('telegator.auth.password_min_length');
        $this->userPassword = Str::random(6);
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
        $this->validator = app()->get('validator');
        $this->rules = (new RegistryRequest())->rules();
        $userModel = new User();
        $this->user = $userModel->createUser('test_email@gmail.com', 'sample123');
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function validationProvider(): array
    {
        /* WithFaker trait doesn't work in the dataProvider */
        $faker = Factory::create(Factory::DEFAULT_LOCALE);
        $userPassword = Str::random(7);

        return [
            'request_should_fail_when_no_email_is_provided' => [
                'passed' => false,
                'data' => [
                    'password' => $faker->asciify('*******')
                ]
            ],
            'request_should_fail_when_email_is_invalid' => [
                'passed' => false,
                'data' => [
                    'email' => $faker->word(),
                    'password' => $faker->asciify('*******')
                ]
            ],
            'request_should_fail_when_email_is_not_string' => [
                'passed' => false,
                'data' => [
                    'email' => $faker->shuffleArray(),
                    'password' => $faker->asciify('*******')
                ]
            ],
            'request_should_fail_when_email_is_grater_when_255' => [
                'passed' => false,
                'data' => [
                    'email' => Str::random(246) . '@gmail.com',
                    'password' => $faker->asciify('*******')
                ]
            ],
            'request_should_fail_when_no_password' => [
                'passed' => false,
                'data' => [
                    'email' => $faker->email(),
                ]
            ],
            'request_should_fail_when_password_is_less_when_6' => [
                'passed' => false,
                'data' => [
                    'email' => $faker->email(),
                    'password' => $faker->asciify('*****')
                ]
            ],
            'request_should_fail_when_password_is_not_string' => [
                'passed' => false,
                'data' => [
                    'email' => $faker->email(),
                    'password' => $faker->randomElements($array = ['a', 'b', 'c'], $count = 5, $allowDuplicates = true)
                ]
            ],
            'request_have_already_registered_email' => [
                'passed' => false,
                'data' => [
                    'email' => $this->user->email,
                    'password' => $faker->randomElements($array = ['a', 'b', 'c'], $count = 5, $allowDuplicates = true)
                ]
            ],
            'request_should_pass_when_data_is_provided' => [
                'passed' => true,
                'data' => [
                    'email' => $faker->email(),
                    'password' => $this->userPassword,
                    'password_confirmation' => $userPassword
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function validation_results_as_expected($shouldPass, $mockedRequestData)
    {
        $this->assertEquals(
            $shouldPass,
            $this->validate($mockedRequestData)
        );
    }

    protected function validate($mockedRequestData)
    {
        dump($mockedRequestData);
        return $this->validator
            ->make($mockedRequestData, $this->rules)
            ->passes();
    }
}

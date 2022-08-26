<?php

namespace Tests\Unit;

use App\Utils\Checker;
use PHPUnit\Framework\TestCase;

class CheckerTest extends TestCase
{
    public function test_isNullableArray()
    {
        $arr = [
            'search' => 0,
            'subs' => null,
            'q1' => [],
            'q2' => [
                'from' => '',
                'to' => null
            ],
        ];

        $this->assertTrue(Checker::isNullableArray($arr));

        $arr['notEmpty'] = 123;

        $this->assertFalse(Checker::isNullableArray($arr));
    }
}

<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Traits\AuthFactoriesTrait;

abstract class TestCase extends BaseTestCase
{
    use AuthFactoriesTrait;
}

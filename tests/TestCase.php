<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function filterKeysFromArray(array $array, array $keysToIgnore): array
    {
        return array_diff_key($array, array_flip($keysToIgnore));
    }
}

<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp()
    {
        parent::setUp();

        // 执行数据迁移
         $this->artisan("migrate");
         $this->artisan("db:seed");

    }
}

<?php

namespace App\Services\Contracts;

abstract class BaseService
{
    protected function withTransaction(callable $cb)
    {
        return \DB::transaction($cb);
    }
}

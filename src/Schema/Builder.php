<?php

namespace Grimzy\LaravelMysqlSpatial\Schema;

use Closure;
use Illuminate\Database\Schema\MySqlBuilder;

class Builder extends MySqlBuilder
{
    protected function createBlueprint($table, ?Closure $callback = null)
    {
        if (version_compare(app()->version(), '12.0.0', '>=')) {
            return new Blueprint($this->connection, $table, $callback);
        }

        return new Blueprint($table, $callback);
    }
}

<?php

namespace Grimzy\LaravelMysqlSpatial\Schema;

use Closure;
use Illuminate\Database\Schema\MySqlBuilder;

class Builder extends MySqlBuilder
{
    protected function createBlueprint($table, ?Closure $callback = null)
    {
        $ref = new \ReflectionClass(\Illuminate\Database\Schema\Blueprint::class);
        $firstParam = $ref->getConstructor()->getParameters()[0] ?? null;

        if ($firstParam && $firstParam->getName() === 'connection') {
            return new Blueprint($this->connection, $table, $callback);
        }

        return new Blueprint($table, $callback);
    }
}

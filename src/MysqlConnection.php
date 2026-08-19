<?php

namespace Grimzy\LaravelMysqlSpatial;

use Grimzy\LaravelMysqlSpatial\Schema\Builder;
use Grimzy\LaravelMysqlSpatial\Schema\Grammars\MySqlGrammar;
use Illuminate\Database\MySqlConnection as IlluminateMySqlConnection;

class MysqlConnection extends IlluminateMySqlConnection
{
    public function __construct($pdo, $database = '', $tablePrefix = '', array $config = [])
    {
        parent::__construct($pdo, $database, $tablePrefix, $config);
    }

    protected function getDefaultSchemaGrammar()
    {
        if (version_compare(app()->version(), '12.0.0', '<')) {
            return $this->withTablePrefix(new MySqlGrammar());
        }

        return new MySqlGrammar($this);
    }

    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new Builder($this);
    }
}

<?php

use Grimzy\LaravelMysqlSpatial\MysqlConnection;
use Grimzy\LaravelMysqlSpatial\Schema\Builder;
use Grimzy\LaravelMysqlSpatial\Schema\Grammars\MySqlGrammar;
use PHPUnit\Framework\TestCase;
use Stubs\PDOStub;

class MysqlConnectionTest extends TestCase
{
    private $mysqlConnection;

    protected function setUp(): void
    {
        $mysqlConfig = ['driver' => 'mysql', 'prefix' => 'prefix', 'database' => 'database', 'name' => 'foo'];
        $this->mysqlConnection = new MysqlConnection(new PDOStub(), 'database', 'prefix', $mysqlConfig);
    }

    public function testGetSchemaBuilder()
    {
        $builder = $this->mysqlConnection->getSchemaBuilder();

        $this->assertInstanceOf(Builder::class, $builder);
    }

    public function testGetDefaultSchemaGrammarDoesNotUseWithTablePrefix()
    {
        $method = new ReflectionMethod(MysqlConnection::class, 'getDefaultSchemaGrammar');
        $method->setAccessible(true);

        $grammar = $method->invoke($this->mysqlConnection);

        $this->assertInstanceOf(MySqlGrammar::class, $grammar);
        $this->assertSame('prefix', $grammar->getTablePrefix());
    }
}

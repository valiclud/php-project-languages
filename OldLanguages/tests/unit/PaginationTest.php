<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use classes\DatabaseTable;
use entities\Pagination;

#[CoversClass(Pagination::class)]
#[UsesClass(DatabaseTable::class)]
#[Small]
final class PaginationTest extends TestCase
{
    private DatabaseTable $paginationTable;
    private Pagination $pagination;

    #[TestDox('Set up database connection and initialize relevant DatabaseTables classes')]
    protected function setUp(): void
    {
        try {
            $pdo = new \PDO('mysql:host=localhost:3306;dbname=old_languages;charset=utf8mb4', 'root', 'lukasa');
            $this->paginationTable = new DatabaseTable($pdo, 'pagination', 'id', '\entities\Pagination');
        } catch (\PDOException $e) {
            echo "$e";
            error_log($e->getMessage());
            throw new \PDOException($e);
        }

        $this->pagination = Pagination::default();
    }

    public function test_default_pagination(): void
    {
        $this->assertSame("", $this->pagination->controller_name);
        $this->assertSame(5, $this->pagination->results);
    }

    protected function tearDown(): void
    {
        try {
            $pdo = null;
        } catch (\PDOException $e) {
            echo "$e";
            error_log($e->getMessage());
            throw new \PDOException($e);
        }
    }
}

<?php

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Small;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use classes\DatabaseTable;
use entities\OriginalText;

#[CoversClass(OriginalText::class)]
#[UsesClass(DatabaseTable::class)]
#[Small]
final class OriginalTextTest extends TestCase
{
    private DatabaseTable $originalTextTable;
    private DatabaseTable $placesTable;
    private DatabaseTable $languageTable;
    private OriginalText $originalText;

    #[TestDox('Set up database connection and initialize relevant DatabaseTables classes')]
    protected function setUp(): void
    {
        try {
            $pdo = new \PDO('mysql:host=localhost:3306;dbname=old_languages;charset=utf8mb4', 'root', 'lukasa');
            $this->placesTable = new DatabaseTable($pdo, 'place', 'id', '\entities\Place');
            $this->languageTable = new DatabaseTable($pdo, 'old_language', 'id', '\entities\OldLanguage');
            $this->originalTextTable = new DatabaseTable($pdo, 'original_text', 'id', '\entities\OriginalText', [&$this->placesTable, &$this->languageTable]);
        } catch (\PDOException $e) {
            echo "<script>console.log('$e');</script>";
            echo "$e";
            throw new \PDOException($e);
        }

        $this->originalText = OriginalText::default($this->placesTable, $this->languageTable);
    }

    public function test_default_original_text(): void
    {
        $this->assertSame("", $this->originalText->author);
        $this->assertSame("", $this->originalText->title);
        $this->assertSame("", $this->originalText->text);
        $this->assertSame("", $this->originalText->century);

        $this->assertSame(date_create()->format('Y-m-d'), $this->originalText->insert_date->format('Y-m-d'));
        $this->assertSame(0, $this->originalText->hits);
    }

    public function test_default_place(): void
    {
        $this->assertSame(0, $this->originalText->getPlace()->id);
        $this->assertSame("", $this->originalText->getPlace()->place);
        $this->assertSame("", $this->originalText->getPlace()->country);
    }

    public function test_default_oldlanguage(): void
    {
        $this->assertSame(0, $this->originalText->getOldLanguage()->id);
        $this->assertSame("", $this->originalText->getOldLanguage()->language);
        $this->assertSame("", $this->originalText->getOldLanguage()->period);
    }

    public function test_author_can_be_changed(): void
    {
        $author = "Cicero";

        $this->originalText->setAuthor($author);

        $this->assertSame($author, $this->originalText->author);
    }

    protected function tearDown(): void
    {
        try {
            $pdo = null;
        } catch (\PDOException $e) {
            echo "<script>console.log('$e');</script>";
            echo "$e";
            throw new \PDOException($e);
        }
    }
}

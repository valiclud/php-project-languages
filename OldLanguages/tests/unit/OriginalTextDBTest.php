<?php 


use PHPUnit\Framework\TestCase;
use classes\DatabaseTable;
use classes\Authentication;


final class OriginalTextDBTest extends TestCase
{

    private ?DatabaseTable $originalTextTable;
    private ?DatabaseTable $placesTable;
    private ?DatabaseTable $languageTable;
    private ?DatabaseTable $translatedTextTable;
    private ?DatabaseTable $authorsTable;
    private ?DatabaseTable $paginationTable;
    private ?Authentication $authentication;
  

    public function setUp() : void
    {
        try {
            $pdo = new \PDO('mysql:host=localhost:3306;dbname=old_languages;charset=utf8mb4', 'root', 'lukasa');
            $this->placesTable = new DatabaseTable($pdo, 'place', 'id', '\entities\Place');
            $this->languageTable = new DatabaseTable($pdo, 'old_language', 'id', '\entities\OldLanguage');
            $this->originalTextTable = new DatabaseTable($pdo, 'original_text', 'id', '\entities\OriginalText', [&$this->placesTable, &$this->languageTable]);
            $this->translatedTextTable = new DatabaseTable($pdo, 'translated_text', 'id', '\entities\TranslatedText', [&$this->originalTextTable]);
            $this->authorsTable = new DatabaseTable($pdo, 'author', 'id', '\entities\Author');
            $this->paginationTable = new DatabaseTable($pdo, 'pagination', 'id', '\entities\Pagination');
            $this->authentication = new Authentication($this->authorsTable, 'email', 'password');
        } catch (\PDOException $e) {
            echo "<script>console.log('$e');</script>";
            echo "$e";
            //throw new \PDOException($e);
        }
    }

    public function test_insert_original_text_to_db(): void
    {
        $originalText['author'] = "Unknown";
        $originalText['title'] = "Battle xxxl";
        $originalText['text'] = "And so on...";
        $originalText['century'] = '1 B.C.';
        $originalText['insert_date'] = date_create()->format('Y-m-d');
        $originalText['hits'] = 2;
        $originalText['place_id'] = 1;
        $originalText['old_language_id'] = 2;

        $savedId = $this->originalTextTable->save($originalText);
        $originalTextDB = $this->originalTextTable->find('id', $savedId)[0] ?? null;

        $this->assertNotNull($originalTextDB);
        $this->assertSame($originalTextDB->author,"Unknown");
        $this->assertSame($originalTextDB->title,"Battle xxxl");
        $this->assertSame($originalTextDB->text,"And so on...");
        $this->assertSame($originalTextDB->century,'1 B.C.');
        $this->assertSame($originalTextDB->insert_date, date_create()->format('Y-m-d'));
        $this->assertSame($originalTextDB->hits,2);
        $this->assertSame($originalTextDB->place_id,1);
        $this->assertSame($originalTextDB->old_language_id,2);

        $this->originalTextTable->delete('id', $savedId);
    }

    public function tearDown() : void
    {
        $pdo = null;
    }


}
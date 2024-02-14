<?php

use PHPUnit\Framework\TestCase;
use classes\DatabaseTable;
use entities\OriginalText;

final class OriginalTextTest extends TestCase
{
    private OriginalText $originalText;

    protected function setUp(): void
    {
        $this->originalText = OriginalText::default();
    }

    public function test_default_original_text(): void
    {
        //$this->assertTrue($this->material->color()->equalTo(Color::from(1, 1, 1)));
        $this->assertSame("", $this->originalText->author);
        $this->assertSame("", $this->originalText->title);
        $this->assertSame("", $this->originalText->text);
        $this->assertSame("", $this->originalText->century);

        $this->assertSame(date_create()->format('Y-m-d'), $this->originalText->insert_date->format('Y-m-d'));
        $this->assertSame(0, $this->originalText->hits);
    }

    public function test_author_can_be_changed(): void
    {
        $author = "Cicero";

        $this->originalText->setAuthor($author);

        $this->assertSame($author, $this->originalText->author);
    }
}

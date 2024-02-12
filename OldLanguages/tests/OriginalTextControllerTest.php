<?php 

use PHPUnit\Framework\TestCase;


final class OriginalTextControllerTest extends TestCase
{
    public function testInsert(): void
    {
        $this->assertSame("x","x");
    }

}
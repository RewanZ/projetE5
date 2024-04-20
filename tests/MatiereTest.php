<?php

namespace App\Tests;

use App\Entity\Matiere;
use PHPUnit\Framework\TestCase;

class MatiereTest extends TestCase
{
    public function testSomething(): void
    {
        $matiere= new Matiere();
        $this->assertNull($matiere->getId());
    }
}

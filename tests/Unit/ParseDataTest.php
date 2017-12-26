<?php

namespace Tests\Unit;

use App\Http\Controllers\Traits\ParseDataTrait;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParseDataTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    use ParseDataTrait;
    public function testParseWeitData()
    {
        $text = 'Weit';
        $this->assertEquals($text, $this->checkJumpDisciplines('Weit'));
        $this->assertEquals($text, $this->checkJumpDisciplines('Weit 1+2'));
        $this->assertEquals($text, $this->checkJumpDisciplines('Weit 3+4'));
        $this->assertEquals($text, $this->checkJumpDisciplines('200 m/ Weit'));
    }

    public function testParseHochData()
    {
        $text = 'Hoch';
        $this->assertEquals($text, $this->checkJumpDisciplines('Hoch'));
        $this->assertEquals($text, $this->checkJumpDisciplines('Hoch  1,35 m'));
    }

    public function testParseKugelData()
    {
        $text = 'Kugel';
        $this->assertEquals($text, $this->checkJumpDisciplines('Kugel'));
        $this->assertEquals($text, $this->checkJumpDisciplines('60 m E A/B/Kugel'));
        $this->assertEquals($text, $this->checkJumpDisciplines('Kugel W15'));
        $this->assertEquals($text, $this->checkJumpDisciplines('Kugel M13'));
    }

    public function testCheckZ()
    {
        $text = '60 m';
        $this->assertEquals($text, $this->checkZ('60 m'));
        $this->assertEquals($text, $this->checkZ('60 m ZL'));
        $this->assertEquals($text, $this->checkZ('60 m ZL/800 m'));
    }

    public function testCheckX()
    {
        $this->assertEquals('4 x 200 m', $this->checkX('4 x 200 m'));
        $this->assertEquals('4 x 50 m', $this->checkX('4 x 50 m'));
        $this->assertEquals('4 x 100 m', $this->checkX('4 x 100 m'));
    }

    public function testParseAgeclass()
    {
        $this->assertEquals('4 x 200 m', $this->checkX('4 x 200 m'));
    }

    public function testFillAgeclassesList()
    {
        $this->fillAgeclassesList('WK U12 * W10/W11');
        print_r($this->ageclassList);
    }
}

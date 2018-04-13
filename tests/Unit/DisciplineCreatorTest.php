<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 11.04.18
 * Time: 12:42
 */

namespace Tests\Unit;

use App\Library\DisciplineCreator;

use Tests\TestCase;
use DOMDocument;

class DisciplineCreatorTest extends TestCase
{

    protected $tableBody;
    protected $tableRaw;

    public function setUp()
    {
        $this->tableRaw = '<table><thead><tr><td class="removethis">head</td></tr></thead><tbody><tr><td class="removethis">17:00</td><td>200m</td></tr><tr><td class="removethis">17:00</td><td>200m/300m</td></tr></tbody></table>';
        $this->tableBody = '<tbody><tr><td>body</td></tr></tbody>';

    }

    public function testIterateDisciplineCollection()
    {
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($this->tableRaw, 'HTML-ENTITIES', 'UTF-8'));
        $expectedBody = $dom->getElementsByTagName('tbody')->item(0);

        $disciplineCreator = new DisciplineCreator;
        $disciplineCreator->setDomDisciplines($expectedBody);
        $disciplineCreator->iterateDisciplineCollection();
        $discipline = $disciplineCreator->getDisciplines();

        $actualDiscipline = [0=> '200 m',2=> '300 m'];
        $this->assertEquals($actualDiscipline,$discipline);
    }

    public function testFillDisciplineList()
    {
        $disciplineCreator = new DisciplineCreator();
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['300m']);
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['300m/200m']);
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['Weit 3+4']);
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['Hoch 2/1,15']);
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['Kugel W 15']);
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['60 m H.']);
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['4 x 50 m']);
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['800 m']);
        $this->invokeMethod($disciplineCreator, 'fillDisciplineList', ['1000m']);
        $disciplines = $disciplineCreator->getDisciplines();
        $this->assertEquals('300 m', $disciplines[0]);
        $this->assertEquals('200 m', $disciplines[2]);
        $this->assertEquals('Weit', $disciplines[3]);
        $this->assertEquals('Hoch', $disciplines[4]);
        $this->assertEquals('Kugel', $disciplines[6]);
        $this->assertEquals('60 m H.', $disciplines[7]);
        $this->assertEquals('4 x 50 m', $disciplines[8]);
        $this->assertEquals('800 m', $disciplines[9]);
        $this->assertEquals('1000 m', $disciplines[10]);
    }

    public function testCheckX()
    {
        $disciplineCreator = new DisciplineCreator();
        $erg = $this->invokeMethod($disciplineCreator, 'checkX', ['4 x 50 m']);
        $this->assertEquals('4 x 50 m', $erg);
        $erg = $this->invokeMethod($disciplineCreator, 'checkX', ['4x50 m']);
        $this->assertEquals('4 x 50 m', $erg);
    }
    public function testCheckJumpDisciplines()
    {
        $disciplineCreator = new DisciplineCreator();
        $erg = $this->invokeMethod($disciplineCreator, 'checkJumpDisciplines', ['Weit']);
        $this->assertEquals('Weit', $erg);
        $erg = $this->invokeMethod($disciplineCreator, 'checkJumpDisciplines', ['Hoch']);
        $this->assertEquals('Hoch', $erg);
        $erg = $this->invokeMethod($disciplineCreator, 'checkJumpDisciplines', ['Hoch 1/1,20']);
        $this->assertEquals('Hoch', $erg);
        $erg = $this->invokeMethod($disciplineCreator, 'checkJumpDisciplines', ['Kugel']);
        $this->assertEquals('Kugel', $erg);
    }

}

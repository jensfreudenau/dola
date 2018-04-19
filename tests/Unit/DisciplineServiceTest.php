<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 12.04.18
 * Time: 14:53
 */

namespace Tests\Unit;

use App\Services\DisciplineService;
use Tests\TestCase;
use DOMDocument;

class DisciplineServiceTest extends TestCase
{
    protected $tableBody;
    protected $tableRaw;
    /** @var \App\Services\DisciplineService */
    protected $disciplineService;

    public function setUp()
    {
        parent::setUp();
        $this->tableRaw          = '<table><thead><tr><td class="removethis">head</td></tr></thead><tbody><tr><td class="removethis">17:00</td><td>200m</td></tr><tr><td class="removethis">17:00</td><td>200m/300m</td></tr></tbody></table>';
        $this->tableBody         = '<tbody><tr><td>body</td></tr></tbody>';
        $this->disciplineService = new DisciplineService;
    }

    public function testCheckX()
    {
        $erg = $this->invokeMethod($this->disciplineService, 'checkX', array('4x 75m'));
        $this->assertEquals('4 x 75m', $erg);
        $erg = $this->invokeMethod($this->disciplineService, 'checkX', array('4 x 75m'));
        $this->assertEquals('4 x 75m', $erg);
        $erg = $this->invokeMethod($this->disciplineService, 'checkX', array('4x75m'));
        $this->assertEquals('4 x 75m', $erg);
        $erg = $this->invokeMethod($this->disciplineService, 'checkX', array('60 m'));
        $this->assertEquals('60 m', $erg);
        $erg = $this->invokeMethod($this->disciplineService, 'checkX', array('4 x75m'));
        $this->assertEquals('4 x 75m', $erg);
    }

    /**
     * Call protected/private method of a class.
     *
     * @param object &$object Instantiated object that we will run method on.
     * @param string $methodName Method name to call
     * @param array $parameters Array of parameters to pass into method.
     *
     * @return mixed Method return.
     * @throws \ReflectionException
     */
    public function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method     = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $parameters);
    }

    public function testCheckZ()
    {
        $disciplineService = new DisciplineService;
        $erg               = $this->invokeMethod($disciplineService, 'checkZ', array('60m ZL'));
        $this->assertEquals('60m', $erg);
    }

    public function testCheckJumpDisciplines()
    {
        $disciplineService = new DisciplineService;
        $erg               = $this->invokeMethod($disciplineService, 'checkJumpDisciplines', array('Hoch 1,15m'));
        $this->assertEquals('Hoch', $erg);
        $disciplineService = new DisciplineService;
        $erg               = $this->invokeMethod($disciplineService, 'checkJumpDisciplines', array('800m/Kugel'));
        $this->assertEquals('Kugel', $erg);
        $disciplineService = new DisciplineService;
        $erg               = $this->invokeMethod($disciplineService, 'checkJumpDisciplines', array('Weit  W14'));
        $this->assertEquals('Weit', $erg);
    }

    public function testProofDisciplineCollection()
    {
        $disciplineService = new DisciplineService;
        $this->invokeMethod($disciplineService, 'proofDisciplineCollection', array('Hoch'));
        $run = $this->invokeMethod($disciplineService, 'checkRunDiscipline', array('1500m'));
        $this->invokeMethod($disciplineService, 'proofDisciplineCollection', array($run));
        $run = $this->invokeMethod($disciplineService, 'checkRunDiscipline', array('60m Hürden'));
        $this->invokeMethod($disciplineService, 'proofDisciplineCollection', array($run));
        $run = $this->invokeMethod($disciplineService, 'checkRunDiscipline', array('60m Hürden WJ U14'));
        $this->invokeMethod($disciplineService, 'proofDisciplineCollection', array($run));
        $discipline = $disciplineService->getProofedDisciplines();
        $this->assertEquals(['THOC' => ['Hoch', 'Hoch'], 'L1K5' => ['1.500m', '1500 m'], 'H60' => ['60m Hürd.', '60 m Hürden']], $discipline);
    }

    public function testIterateDisciplineCollection()
    {
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($this->tableRaw, 'HTML-ENTITIES', 'UTF-8'));
        $expectedBody = $dom->getElementsByTagName('tbody')->item(0);
        $disciplineService = new DisciplineService;
        $disciplineService->setDomDisciplines($expectedBody);
        $disciplineService->iterateDisciplineCollection();
        $discipline = $disciplineService->getDisciplines();
        $actualDiscipline = [0 => '200 m', 2 => '300 m'];
        $this->assertEquals($actualDiscipline, $discipline);
    }

    public function testGetDisciplineCollectionError()
    {
        $disciplineService = new DisciplineService;
        $this->invokeMethod($disciplineService, 'proofDisciplineCollection', array('Hoch'));
        $this->invokeMethod($disciplineService, 'proofDisciplineCollection', array('Hoch123'));
        $disciplineError = $disciplineService->getDisciplineCollectionError();
        $this->assertEquals([0 => 'Hoch123'], $disciplineError);
    }
}

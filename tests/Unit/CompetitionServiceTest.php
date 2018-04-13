<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 11.04.18
 * Time: 14:52
 */

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use App\Services\CompetitionService;

class CompetitionServiceTest extends TestCase
{
    protected $competitonService;

    public function tearDown()
    {
        Mockery::close();
    }

    public function setUp()
    {
        $competitionRepo         = Mockery::mock('alias:App\Repositories\Competition\CompetitionRepositoryInterface');
        $additionalRepo          = Mockery::mock('alias:App\Repositories\Additional\AdditionalRepositoryInterface');
        $ageclassRepo            = Mockery::mock('alias:App\Services\AgeclassService');
        $disciplineService       = Mockery::mock('alias:App\Services\DisciplineService');
        $this->competitonService = new CompetitionService($competitionRepo, $additionalRepo, $ageclassRepo, $disciplineService);
    }

    public function testStoreTimetableData()
    {
        $this->assertEquals(1,1);
    }
}

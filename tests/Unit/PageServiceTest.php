<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 10.04.18
 * Time: 16:10
 */

namespace Tests\Unit;

use App\Services\PageService;
use Mockery;
use Tests\TestCase;




class PageServiceTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testFindMnemonic()
    {
        $ageRepo = Mockery::mock('alias:App\Repositories\Ageclass\AgeclassRepositoryInterface');
        $pageRepo = Mockery::mock('alias:App\Repositories\Page\PageRepositoryInterface');
        $pageRepo->shouldReceive('findBy')->andReturn('Kampfrichter-Infos');

        $pageService = new PageService($ageRepo, $pageRepo);

        $this->assertEquals('Kampfrichter-Infos', $pageService->findMnemonic('kampfrichter'));

    }
}

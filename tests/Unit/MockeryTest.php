<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 01.03.18
 * Time: 14:28
 */

namespace Tests\Unit;

use App\Services\PageService;
use Tests\TestCase;
use Mockery;

class Foo
{
    protected $bar;

    public function __construct($bar)
    {
        $this->bar = $bar;
    }

    public function fire()
    {
        echo 'do straneg things';
        return $this->bar->doIt([]);
    }
}

class Bar
{
    public function doIt(array $t)
    {
        return 'doing it';
    }
}

class Curl
{
    public function post()
    {
        return 'post request was made';
    }
}

class Newsletter
{
    protected $listName;
    protected $curl;

    public function __construct($curl)
    {
        $this->curl = $curl;
    }

    public function addToList($listname)
    {
        $data = [
            'email' => 'foo@bar.com',
            'list'  => $listname
        ];
        return $this->curl->post($data);
    }
}

class MockeryTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function testBearthyearRange()
    {
        $ageClass = new PageService();
        $range = $ageClass->createBirthyearRange('0-7');
        $this->assertEquals($range, '2011-2018');
    }

    public function test_adds_newsletter_list()
    {
        $curl = Mockery::mock('Curl');
        $curl->shouldReceive('post')->once()->andReturn('mocked');
        $newsletter = new Newsletter($curl);
        $result     = $newsletter->addToList('foo-list');
        $this->assertEquals('mocked', $result);
    }

    public function testBasicExample()
    {
        $bar = Mockery::mock('Bar')->makePartial();
        $bar->shouldReceive('doIt')->with([])->andReturn('doing it');
        $foo    = new Foo($bar);
        $output = $foo->fire();
        $this->assertEquals('doing it', $output);
    }
}

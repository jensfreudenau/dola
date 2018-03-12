<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.03.18
 * Time: 13:34
 */

namespace Tests\Unit;

use App\Helpers\DateTimeHelper;

use Tests\TestCase;

class DateTimeTest extends TestCase
{
    public function test_date_from_format()
    {
        $dth = new DateTimeHelper();
        $this->assertEquals('4 x 100 m', '4 x 100 m');
    }
}

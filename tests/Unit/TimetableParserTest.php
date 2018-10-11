<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 12.04.18
 * Time: 11:25
 */

namespace Tests\Unit;

use App\Library\HtmlTagCleaner;
use App\Library\TimetableParser;
use DOMDocument;
use Mockery;
use Tests\TestCase;

class TimetableParserTest extends TestCase
{
    /** @var \App\Library\TimetableParser */
    protected $timetableParser;
    protected $tableRaw;
    protected $table;
    protected $tableHead;
    protected $tableBody;

    public function setUp()
    {
        $this->tableRaw = '<table><thead><tr><td class="removethis">head</td></tr></thead><tbody><tr><td class="removethis">body</td></tr></tbody></table>';
        $this->table = '<table><thead><tr><td>head</td></tr></thead><tbody><tr><td>body</td></tr></tbody></table>';
        $htmlTagCleaner = new HtmlTagCleaner();
        $this->invokeMethod($htmlTagCleaner, 'createRawHtml',[$this->tableRaw]);
        $this->timetableParser = new TimetableParser($htmlTagCleaner);
    }
    public function testGetTableHeader()
    {

        $this->timetableParser->proceed($this->tableRaw);
        $actualHeader = $this->timetableParser->getHeader();

        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($this->tableRaw, 'HTML-ENTITIES', 'UTF-8'));
        $expectedHeader = $dom->getElementsByTagName('thead')->item(0);
        $this->assertEqualXMLStructure(
               $expectedHeader->firstChild, $actualHeader->firstChild
        );
    }

    public function testGetTableBody()
    {
        $this->timetableParser->proceed($this->tableRaw);

        $actualBody = $this->timetableParser->getTableBody();

        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($this->tableRaw, 'HTML-ENTITIES', 'UTF-8'));
        $expectedBody = $dom->getElementsByTagName('tbody')->item(0);
        $this->assertEqualXMLStructure(
            $expectedBody->firstChild, $actualBody->firstChild
        );
    }

    public function testCreateTable()
    {
        $this->timetableParser->proceed($this->tableRaw);
        $table = $this->timetableParser->getTimeTable();
        $this->assertEquals($this->table, $table);
    }


}

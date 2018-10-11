<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.03.18
 * Time: 17:54
 */

namespace App\Library;


class TimetableParser
{
    public $ageclass;
    public $discipline;

    protected $theader;
    protected $tbody;
    protected $timeTable;
    protected $ignoreAgeClasses;
    /**
     * @var htmlTagCleaner
     */
    private $htmlTagCleaner;

    /**
     * TimetableParser constructor.
     * @param HtmlTagCleaner $htmlTagCleaner
     */
    public function __construct(HtmlTagCleaner $htmlTagCleaner)
    {
        $this->htmlTagCleaner = $htmlTagCleaner;
    }

    public function proceed($table)
    {
        $this->htmlTagCleaner->createRawHtmlTable($table);
    }

    /**
     * @return mixed theader
     */
    public function getHeader()
    {
        return $this->htmlTagCleaner->getHeader();
    }

    /**
     * @return mixed tbody
     */
    public function getTableBody()
    {
        return $this->htmlTagCleaner->dom->getElementsByTagName('tbody')->item(0);
    }

    /**
     * @return mixed
     */
    public function getTimeTable()
    {
        return trim(str_replace(PHP_EOL, ' ', $this->htmlTagCleaner->getTable()));
    }

    public function setTimeTableRaw($timeTable)
    {
        $this->timeTable = $timeTable;
    }

    public function setIgnoreAgeclasses($customAgeclasses)
    {
        $this->ignoreAgeClasses = $customAgeclasses;
    }
}
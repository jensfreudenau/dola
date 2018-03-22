<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.03.18
 * Time: 17:54
 */

namespace App\Library;
use DOMDocument;
use DOMXPath;

class TimetableParser
{
    public    $ageclass;
    public    $discipline;
    protected $dom;
    protected $theader;
    protected $tbody;
    protected $timeTable;
    protected $ignoreAgeClasses;

    /**
     * TimetableParser constructor.
     */
    public function __construct()
    {
        $this->dom                     = new DOMDocument();
        $this->dom->preserveWhiteSpace = false;
    }

    public function loadIntoDom()
    {
        $this->timeTable = preg_replace(array('/\r/', '/\n/'), '', $this->timeTable);
        $this->dom->loadHTML(mb_convert_encoding($this->timeTable, 'HTML-ENTITIES', 'UTF-8'));
        $this->theader = $this->dom->getElementsByTagName('thead')->item(0);
        $this->tbody   = $this->dom->getElementsByTagName('tbody')->item(0);
    }

    public function createTable()
    {
        $this->dom->loadHTML($this->timeTable, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($this->dom);
        $nodes = $xpath->query('//@*');
        foreach ($nodes as $node) {
            $node->parentNode->removeAttribute($node->nodeName);
        }
        $this->timeTable =  $this->dom->saveHTML();
    }

    /**
     * @return mixed theader
     */
    public function getHeader()
    {
        return $this->theader;
    }

    /**
     * @return mixed tbody
     */
    public function getTableBody()
    {
        return $this->tbody;
    }

    /**
     * @return mixed
     */
    public function getTimeTable()
    {
        return $this->timeTable;
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
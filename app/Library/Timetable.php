<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 05.03.18
 * Time: 17:54
 */

namespace App\Library;

class Timetable extends Dom
{
    public    $ageclass;
    public    $discipline;
    protected $dom;
    protected $theader;
    protected $tbody;
    protected $timeTable;
    protected $ignoreAgeClasses;

    public function __construct(Ageclass $ageclass, Discipline $discipline)
    {
        $this->ageclass = $ageclass;
        $this->discipline = $discipline;
        parent::__construct();
    }

    public function loadIntoDom()
    {
        $this->timeTable = preg_replace(array('/\r/', '/\n/'), '', $this->timeTable);
        $this->dom->loadHTML(mb_convert_encoding($this->timeTable, 'HTML-ENTITIES', 'UTF-8'));
    }

    public function parsingTable()
    {
        $this->theader = $this->dom->getElementsByTagName('thead')->item(0);
        $this->tbody = $this->dom->getElementsByTagName('tbody')->item(0);
        if (empty($this->ignoreAgeClasses)) {
            $this->ageclass->setDomAgeclasses($this->theader);
            $this->ageclass->iterateAgeclassCollection();
        }

        $this->discipline->setDomDisciplines($this->tbody);
        $this->discipline->iterateDisciplineCollection();

        $this->timeTable = $this->createTable($this->timeTable);

    }

    /**
     * @return mixed
     */
    public function getTimeTable()
    {
        return $this->timeTable;
    }

    public function setTimeTable($timeTable)
    {
        $this->timeTable = $timeTable;
    }

    public function setIgnoreAgeclasses($customAgeclasses)
    {
        $this->ignoreAgeClasses = $customAgeclasses;
    }
}
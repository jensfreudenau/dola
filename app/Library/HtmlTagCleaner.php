<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 27.09.18
 * Time: 13:37
 */

namespace App\Library;

use App\Models\Ageclass;
use DOMDocument;
use DOMXPath;

class HtmlTagCleaner
{
    public $dom;
    protected $table;
    protected $header;
    protected $body;
    protected $classes;
    protected $ageclassCollectionError;
    protected $ageclassCollection;
    protected $domAgeclasses;

    public function __construct()
    {
        $this->dom                     = new DOMDocument();
        $this->dom->preserveWhiteSpace = false;
    }

    public function createRawHtmlTable($table)
    {
        $this->loadIntoDom($table);
        $this->createHtmlTable();
    }

    protected function loadIntoDom($table)
    {
        $this->table = preg_replace(array('/\r/', '/\n/'), '', $table);
        $this->dom->loadHTML(mb_convert_encoding($this->table, 'HTML-ENTITIES', 'UTF-8'));
        $this->header = $this->dom->getElementsByTagName('thead')->item(0);
        $this->body   = $this->dom->getElementsByTagName('tbody')->item(0);
    }

    protected function createHtmlTable()
    {
        $this->dom->loadHTML($this->table, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($this->dom);
        $nodes = $xpath->query('//@*');
        foreach ($nodes as $node) {
            $node->parentNode->removeAttribute($node->nodeName);
        }
        $this->table = $this->dom->saveHTML();
    }

    public function getHeader()
    {
        return $this->header;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getTable(): string
    {
        return $this->table;
    }


}
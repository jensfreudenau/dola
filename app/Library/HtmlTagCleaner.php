<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 27.09.18
 * Time: 13:37
 */

namespace App\Library;

use DOMDocument;
use DOMXPath;

class HtmlTagCleaner
{
    protected $table;
    protected $header;
    protected $body;

    public function __construct()
    {
        $this->dom                     = new DOMDocument();
        $this->dom->preserveWhiteSpace = false;
    }

    public function createRawHtml($table)
    {
        $this->loadIntoDom($table);
        $this->createHtml();
    }

    protected function loadIntoDom($table)
    {
        $this->table = preg_replace(array('/\r/', '/\n/'), '', $table);
        $this->dom->loadHTML(mb_convert_encoding($this->table, 'HTML-ENTITIES', 'UTF-8'));
        $this->header = $this->dom->getElementsByTagName('thead')->item(0);
        $this->body   = $this->dom->getElementsByTagName('tbody')->item(0);
    }

    protected function createHtml()
    {
        $this->dom->loadHTML($this->table, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($this->dom);
        $nodes = $xpath->query('//@*');
        foreach ($nodes as $node) {
            $node->parentNode->removeAttribute($node->nodeName);
        }
        $this->table = $this->dom->saveHTML();
    }

    public function getHeader(): object
    {
        return $this->header;
    }

    public function getBody(): object
    {
        return $this->body;
    }

    public function getTable(): string
    {
        return $this->table;
    }
}
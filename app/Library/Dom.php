<?php
/**
 * Created by IntelliJ IDEA.
 * User: jensfreudenau
 * Date: 06.03.18
 * Time: 10:46
 */

namespace App\Library;

use DOMDocument;
use DOMXPath;

class Dom
{
    public function __construct()
    {
        $this->dom                     = new DOMDocument();
        $this->dom->preserveWhiteSpace = false;
    }

    public function createTable($html)
    {
        $this->dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($this->dom);
        $nodes = $xpath->query('//@*');
        foreach ($nodes as $node) {
            $node->parentNode->removeAttribute($node->nodeName);
        }
        return $this->dom->saveHTML();
    }
}
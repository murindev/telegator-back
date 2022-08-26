<?php

namespace App\Utils;

use DOMDocument;
use DOMXPath;
use DOMNode;

class DOMDocumentXPathParser
{
    private  DOMDocument $doc;
    private  DOMXPath    $xpath;
    private ?DOMNode     $contextNode = null;

    public function __construct(DOMDocument $doc, ?DOMXPath $xpath = null, ?DOMNode $contextNode = null)
    {
        $this->doc         = $doc;
        $this->xpath       = $xpath ?: new DOMXPath($this->doc);
        $this->contextNode = $contextNode;
        return $this->optimiseExpression('');
    }

    public static function create(string $html): DOMDocumentXPathParser
    {
        $doc = new DOMDocument();
        $doc->loadHTML($html, LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_COMPACT | LIBXML_HTML_NOIMPLIED | LIBXML_NSCLEAN | LIBXML_PEDANTIC);
        return new static($doc);
    }

    public function query($expression)
    {
        return $this->xpath->query($this->optimiseExpression($expression), $this->contextNode);
    }

    public function evaluate($expression)
    {
        return $this->xpath->evaluate($this->optimiseExpression($expression), $this->contextNode);
    }

    public function evaluateFirst($expression): ?DOMNode
    {
        return $this->query($expression)->item(0);
    }

    public function clone(DOMNode $node): DOMDocumentXPathParser
    {
        return new static($this->doc, $this->xpath, $node);
    }

    private function optimiseExpression (string $expression): string
    {
        return preg_replace(
            '%#(?:@class=)?[\'"]?(.*?)[\'"]?#%',
            "[contains(concat(' ',normalize-space(@class),' '),' $1 ')]",
            $expression
        );
    }
}

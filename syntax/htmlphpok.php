<?php
/**
 * DokuWiki Plugin htmlok (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  saggi <saggi@gmx.de>
 *
 * Uses the following library:
 *
 * Website: http://sourceforge.net/projects/simplehtmldom/
 * Additional projects: http://sourceforge.net/projects/debugobject/
 * Acknowledge: Jose Solorzano (https://sourceforge.net/projects/php-html/)
 *
 * Licensed under The MIT License
 * See the LICENSE file in the project root for more information.
 *
 * Authors:
 *   S.C. Chen
 *   John Schlick
 *   Rus Carroll
 *   logmanoriginal
 *
 * Contributors:
 *   Yousuke Kumakura
 *   Vadim Voituk
 *   Antcs
 *
 * Version Rev. 1.9.1 (291)
 */

use dokuwiki\Extension\SyntaxPlugin;

include (__DIR__ . '\..\assets\simplehtmldom\simple_html_dom.php');
class syntax_plugin_htmlok_htmlphpok extends SyntaxPlugin
{
    protected static $allowedTags;
    protected static $allowedAttributes;

    public function GetAllowedTags()
    {
        if (!self::$allowedTags) {
            if(!count($this->getConf('allowedtags'))) {return array();}
            self::$allowedTags = $this->getConf('allowedtags');
            self::$allowedTags = array_map('strtolower', self::$allowedTags);
            self::$allowedTags = array_map('trim', self::$allowedTags);
        }
        return self::$allowedTags;
    }

    public function GetAllowedAttributes()
    {
        if (!self::$allowedAttributes) {
            if(!count($this->getConf('allowedattr'))) {return array();}
            self::$allowedAttributes = $this->getConf('allowedattr');
            self::$allowedAttributes = array_map('strtolower',self::$allowedAttributes);
            self::$allowedAttributes = array_map('trim',self::$allowedAttributes);
        }
        return self::$allowedAttributes;
    }

    /** @inheritDoc */
    public function getType()
    {
        return 'protected';
    }

    /** @inheritDoc */
    public function getPType()
    {
        return 'normal';
    }

    /** @inheritDoc */
    public function getSort()
    {
        return 179;
    }


    /** @inheritDoc */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        return array();
    }

    /** @inheritDoc */
    public function render($mode, Doku_Renderer $renderer, $data)
    {
        if ($mode !== 'xhtml') {
            return false;
        }
        return true;
    }

    public function RemoveBadHTML($match, $addTag = false)
    {
        $htmlreturn = '';
        $allowedTags = self::GetAllowedTags();
        $allowedAttributes = self::GetAllowedAttributes();
        if(!count($allowedAttributes) && !count($allowedTags)) {
            return $match;
        }
        if ($addTag) {
            $randomStartTag = date('YmdHis');
            $allowedTags[] = $randomStartTag;
            $randomEndTag = '</' . $randomStartTag .'>';
            $randomStartTag = '<' . $randomStartTag .'>';
            $match = $randomStartTag . $match . $randomEndTag;
        }
        $htmltotest = str_get_html($match);
        if (!empty($htmltotest)) {
            foreach($htmltotest->find('*') as $element) {
                if(!in_array($element->tag, $allowedTags, true)) {
                    if($this->getConf('showdenied')) {
                        $element->outertext = '<p>' . str_replace('%s', $element->tag, $this->getLang('msgremovedtag')) . '</p>';
                        $element->outertext .= '<pre>' . hsc($element->innertext) . '</pre>';
                    } else {
                        $element->outertext = '';
                    }
                }
                if(!empty($element)) {
                    foreach($element->childNodes() as $child) {
                        $child->outertext = $this->RemoveBadHTML($child->outertext);
                    }
                    foreach($element->getAllAttributes() as $attr => $var) {
                        if(!in_array($attr, $allowedAttributes, true)) {
                            $element->removeAttribute($attr);
                        }
                    }
                }
            }
            $htmlreturn = $htmltotest->save();
            // clean up memory
            $htmltotest->clear();
            unset($htmltotest);
            if ($addTag) {
                $htmlreturn = trim(substr($htmlreturn, strlen($randomStartTag),strlen($randomEndTag) * -1));
            }
        }
        return $htmlreturn;
    }

}


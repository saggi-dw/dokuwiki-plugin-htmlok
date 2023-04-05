<?php
/**
 * DokuWiki Plugin htmlok (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  saggi <saggi@gmx.de>
 */
class syntax_plugin_htmlok_htmlblock extends \dokuwiki\Extension\SyntaxPlugin
{
    /** @inheritDoc */
    public function getType()
    {
        return 'protected';
    }

    /** @inheritDoc */
    public function getPType()
    {
        return 'block';
    }

    /** @inheritDoc */
    public function getSort()
    {
        return 190;
    }

    /** @inheritDoc */
    public function connectTo($mode)
    {
        $this->Lexer->addEntryPattern('<HTML>(?=.*?</HTML>)', $mode, 'plugin_htmlok_htmlblock');
    }

    /** @inheritDoc */
    public function postConnect()
    {
        $this->Lexer->addExitPattern('</HTML>', 'plugin_htmlok_htmlblock');
    }

    /** @inheritDoc */
    public function handle($match, $state, $pos, Doku_Handler $handler)
    {
        switch ($state) {
            case DOKU_LEXER_ENTER :
                return array($state,$match);
            case DOKU_LEXER_UNMATCHED :
                return array($state,$match);
            case DOKU_LEXER_EXIT :
                return array($state,'');
        }
        return array();
    }

    /** @inheritDoc */
    public function render($mode, Doku_Renderer $renderer, $data)
    {
        if ($mode !== 'xhtml') {
            return false;
        }
        list($state,$match) = $data;
        switch ($state) {
            case DOKU_LEXER_ENTER :
                $renderer->doc .= '<div class="htmlblock">'. DOKU_LF;
                break;
            case DOKU_LEXER_UNMATCHED :
                If ($this->getConf('htmlok')) {
                    $renderer->doc .= $match;
                } else {
                    $renderer->doc .= p_xhtml_cached_geshi($match, 'html4strict', 'pre');
                }
                break;
            case DOKU_LEXER_EXIT :
                $renderer->doc .= '</div>'. DOKU_LF;
                break;
        }
        return true;
    }
}


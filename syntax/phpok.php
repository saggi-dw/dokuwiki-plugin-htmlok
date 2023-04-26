<?php
/**
 * DokuWiki Plugin htmlok (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  saggi <saggi@gmx.de>
 */
class syntax_plugin_htmlok_phpok extends syntax_plugin_htmlok_htmlphpok
{
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
    public function connectTo($mode)
    {
        $this->Lexer->addEntryPattern('<php>(?=.*?</php>)', $mode, 'plugin_htmlok_phpok');
    }

    /** @inheritDoc */
    public function postConnect()
    {
        $this->Lexer->addExitPattern('</php>', 'plugin_htmlok_phpok');
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
                break;
            case DOKU_LEXER_UNMATCHED :
                If ($this->getConf('phpok')) {
                    ob_start();
                    eval($match);
                    $renderer->doc .= ob_get_contents();
                    ob_end_clean();
                } else {
                    $renderer->doc .= p_xhtml_cached_geshi($match, 'php', 'code');
                }
                break;
            case DOKU_LEXER_EXIT :
                break;
        }
        return true;
    }
}


<?php
/**
 * DokuWiki Plugin htmlok (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  saggi <saggi@gmx.de>
 */

use dokuwiki\plugin\htmlok\syntax\BaseSyntaxPlugin;

class syntax_plugin_htmlok_htmlok extends BaseSyntaxPlugin
{
    protected $type = 'protected';
    protected $ptype = 'normal';
    protected $sort = 190;

    /** @inheritDoc */
    public function connectTo($mode)
    {
        $this->Lexer->addEntryPattern('<html>(?=.*?</html>)', $mode, 'plugin_htmlok_htmlok');
    }

    /** @inheritDoc */
    public function postConnect()
    {
        $this->Lexer->addExitPattern('</html>', 'plugin_htmlok_htmlok');
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
                If ($this->getConf('htmlok')) {
                    $renderer->doc .= $match;
                } else {
                    $renderer->doc .= p_xhtml_cached_geshi($match, 'html4strict', 'code');
                }
                break;
            case DOKU_LEXER_EXIT :
                break;
        }
        return true;
    }
}


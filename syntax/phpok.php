<?php
/**
 * DokuWiki Plugin htmlok (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  saggi <saggi@gmx.de>
 */

use dokuwiki\plugin\htmlok\syntax\BaseSyntaxPlugin;

class syntax_plugin_htmlok_phpok extends BaseSyntaxPlugin
{
    protected $ptype = 'normal';
    protected $sort = 180;
    protected $tag = 'php';
    protected $mode = 'plugin_htmlok_phpok';

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

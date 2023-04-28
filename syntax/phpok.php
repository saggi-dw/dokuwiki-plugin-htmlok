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

    protected function renderMatch(string $match): string
    {
        if ($this->getConf('phpok')) {
            $contents = $this->renderPhp($match);
        } else {
            $contents = p_xhtml_cached_geshi($match, 'php', 'code');
        }

        return $contents;
    }
}

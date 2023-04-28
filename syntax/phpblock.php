<?php

/**
 * DokuWiki Plugin htmlok (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  saggi <saggi@gmx.de>
 */

use dokuwiki\plugin\htmlok\BaseSyntaxPlugin;

class syntax_plugin_htmlok_phpblock extends BaseSyntaxPlugin
{
    protected $ptype = 'block';
    protected $sort = 180;
    protected $tag = 'PHP';
    protected $mode = 'plugin_htmlok_phpblock';
    protected $class = 'phpok';

    protected function renderMatch(string $match): string
    {
        if ($this->getConf('phpok')) {
            $contents = $this->renderPhp($match);
        } else {
            $contents = p_xhtml_cached_geshi($match, 'php', 'pre');
        }

        return $contents;
    }
}

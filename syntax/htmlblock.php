<?php
/**
 * DokuWiki Plugin htmlok (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  saggi <saggi@gmx.de>
 */

use dokuwiki\plugin\htmlok\BaseSyntaxPlugin;

class syntax_plugin_htmlok_htmlblock extends BaseSyntaxPlugin
{
    protected $ptype = 'block';
    protected $sort = 190;
    protected $tag = 'HTML';
    protected $mode = 'plugin_htmlok_htmlblock';
    protected $class = 'htmlblock';

    protected function renderMatch(string $match): string
    {
        if ($this->getConf('htmlok')) {
            $contents = $match;
        } else {
            $contents = p_xhtml_cached_geshi($match, 'html4strict', 'pre');
        }

        return $contents;
    }
}

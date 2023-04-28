<?php
/**
 * DokuWiki Plugin htmlok (Syntax Component)
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  saggi <saggi@gmx.de>
 * @author  Elan Ruusamäe <glen@delfi.ee>
 */

namespace dokuwiki\plugin\htmlok\syntax;

use Doku_Handler;

abstract class BaseSyntaxPlugin extends \dokuwiki\Extension\SyntaxPlugin
{
    public function handle($match, $state, $pos, Doku_Handler $handler): array
    {
        switch ($state) {
            case DOKU_LEXER_ENTER:
                return [$state, $match];
            case DOKU_LEXER_UNMATCHED:
                return [$state, $match];
            case DOKU_LEXER_EXIT:
                return [$state, ''];
        }

        return [];
    }
}

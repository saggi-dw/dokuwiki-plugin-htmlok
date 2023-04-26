<?php
/**
 * Default settings for the htmlok plugin
 *
 * @author saggi <saggi@gmx.de>
 */

$conf['htmlok']      = 0;                //may raw HTML be embedded? This may break layout and XHTML validity 0|1
$conf['phpok']       = 0;                //may PHP code be embedded? Never do this on the internet! 0|1
$conf['allowedtags'] = 'a, abbr, acronym, address, b, basefont, bdo, big, blockquote, br, caption, center, cite, code, col, colgroup, dd, del, dfn, dir, div, dl, dt, em, font, h1, h2, h3, h4, h5, h6, hr, i, img, ins, kbd, li, menu, ol, p, pre, q, s, samp, small, span, strike, strong, sub, sup, table, tbody, td, tfoot, th, thead, tr, tt, u, ul, var';
$conf['showdenied']  = 1;
$conf['allowedattr'] = 'abbr, accept, accept-charset, accesskey, action, align, alt, axis, border, cellpadding, cellspacing, char, charoff, charset, checked, cite, class, clear, cols, colspan, color, compact, coords, datetime, dir, disabled, enctype, for, frame, headers, height, href, hreflang, hspace, id, ismap, label, lang, longdesc, maxlength, media, method, multiple, name, nohref, noshade, nowrap, prompt, readonly, rel, rev, rows, rowspan, rules, scope, selected, shape, size, span, src, srcset, start, summary, tabindex, target, title, type, usemap, valign, value, vspace, width';

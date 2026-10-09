<?php

/**
 * SCSSPHP
 *
 * @copyright 2012-2020 Leaf Corcoran
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace Flames\Transpiler\Scss;

/**
 * Block/node types
 *
 * @author Anthon Pang <anthon.pang@gmail.com>
 */
final class Type
{
    const string T_COLOR = 'color';
    /**
     * @internal
     */
    const string T_KEYWORD = 'keyword';
    const string T_LIST = 'list';
    const string T_MAP = 'map';
    const string T_NULL = 'null';
    const string T_NUMBER = 'number';
    const string T_STRING = 'string';
}

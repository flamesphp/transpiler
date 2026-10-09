<?php

/**
 * SCSSPHP
 *
 * @copyright 2018-2020 Anthon Pang
 *
 * @license http://opensource.org/licenses/MIT MIT
 *
 * @link http://scssphp.github.io/scssphp
 */

namespace Flames\Transpiler\Scss\SourceMap;

/**
 * @internal
 */
final readonly class TargetLineEntry
{
    /**
     * @param \ArrayObject<int, TargetEntry> $entries
     */
    public function __construct(
        public int $line,
        public \ArrayObject $entries,
    ) {
    }
}

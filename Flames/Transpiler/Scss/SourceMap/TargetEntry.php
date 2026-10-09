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
 * A target segment entry read from a source map
 *
 * @internal
 */
final readonly class TargetEntry
{
    public function __construct(
        public int $column,
        public ?int $sourceUrlId = null,
        public ?int $sourceLine = null,
        public ?int $sourceColumn = null,
    ) {
    }
}

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

namespace Flames\Transpiler\Scss\Value;

use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * @internal
 */
final readonly class SpanColorFormat implements ColorFormat
{
    public function __construct(private FileSpan $span)
    {
    }

    public function getOriginal(): string
    {
        return $this->span->getText();
    }
}

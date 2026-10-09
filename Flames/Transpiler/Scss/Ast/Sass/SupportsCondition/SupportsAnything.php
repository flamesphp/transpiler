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

namespace Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;

use Flames\Transpiler\Scss\Ast\Sass\Interpolation;
use Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A supports condition that represents the forwards-compatible
 * `<general-enclosed>` production.
 *
 * @internal
 */
final readonly class SupportsAnything implements SupportsCondition
{
    public function __construct(
        /**
         * The contents of the condition.
         */
        private Interpolation $contents,
        private FileSpan $span
    )
    {
    }

    public function getContents(): Interpolation
    {
        return $this->contents;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        return "($this->contents)";
    }
}

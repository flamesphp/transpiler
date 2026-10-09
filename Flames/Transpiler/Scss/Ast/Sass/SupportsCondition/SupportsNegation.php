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

use Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A negated condition.
 *
 * @internal
 */
final readonly class SupportsNegation implements SupportsCondition
{
    public function __construct(
        /**
         * The condition that's been negated.
         */
        private SupportsCondition $condition,
        private FileSpan $span
    )
    {
    }

    public function getCondition(): SupportsCondition
    {
        return $this->condition;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        if ($this->condition instanceof SupportsNegation || $this->condition instanceof SupportsOperation) {
            return "not ($this->condition)";
        }

        return 'not ' . $this->condition;
    }
}

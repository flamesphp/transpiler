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

use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An interpolated condition.
 *
 * @internal
 */
final readonly class SupportsInterpolation implements SupportsCondition
{
    public function __construct(
        /**
         * The expression in the interpolation.
         */
        private Expression $expression,
        private FileSpan $span
    )
    {
    }

    public function getExpression(): Expression
    {
        return $this->expression;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        return '#{' . $this->expression . '}';
    }
}

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

namespace Flames\Transpiler\Scss\Ast\Sass\Expression;

use Flames\Transpiler\Scss\Ast\Sass\ArgumentInvocation;
use Flames\Transpiler\Scss\Ast\Sass\CallableInvocation;
use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Ast\Sass\Interpolation;
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An interpolated function invocation.
 *
 * This is always a plain CSS function.
 *
 * @internal
 */
final readonly class InterpolatedFunctionExpression implements Expression, CallableInvocation
{
    public function __construct(
        /**
         * The name of the function being invoked.
         */
        private Interpolation $name,
        /**
         * The arguments to pass to the function.
         */
        private ArgumentInvocation $arguments,
        private FileSpan $span
    )
    {
    }

    public function getName(): Interpolation
    {
        return $this->name;
    }

    public function getArguments(): ArgumentInvocation
    {
        return $this->arguments;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitInterpolatedFunctionExpression($this);
    }

    public function __toString(): string
    {
        return $this->name . $this->arguments;
    }
}

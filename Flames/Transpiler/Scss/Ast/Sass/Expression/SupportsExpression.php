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

use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An expression-level `@supports` condition.
 *
 * This appears only in the modifiers that come after a plain-CSS `@import`. It
 * doesn't include the function name wrapping the condition.
 *
 * @internal
 */
final readonly class SupportsExpression implements Expression
{
    public function __construct(private SupportsCondition $condition)
    {
    }

    public function getCondition(): SupportsCondition
    {
        return $this->condition;
    }

    public function getSpan(): FileSpan
    {
        return $this->condition->getSpan();
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitSupportsExpression($this);
    }

    public function __toString(): string
    {
        return (string) $this->condition;
    }
}

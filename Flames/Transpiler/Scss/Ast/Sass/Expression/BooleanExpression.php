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
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A boolean literal, `true` or `false`.
 *
 * @internal
 */
final readonly class BooleanExpression implements Expression
{
    public function __construct(private bool $value, private FileSpan $span)
    {
    }

    public function getValue(): bool
    {
        return $this->value;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitBooleanExpression($this);
    }

    public function __toString(): string
    {
        return $this->value ? 'true' : 'false';
    }
}

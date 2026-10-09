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
use Flames\Transpiler\Scss\Value\SassColor;
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A color literal.
 *
 * @internal
 */
final readonly class ColorExpression implements Expression
{
    public function __construct(private SassColor $value, private FileSpan $span)
    {
    }

    public function getValue(): SassColor
    {
        return $this->value;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitColorExpression($this);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}

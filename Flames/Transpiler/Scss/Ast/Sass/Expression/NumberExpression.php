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
use Flames\Transpiler\Scss\Value\SassNumber;
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A number literal.
 *
 * @internal
 */
final readonly class NumberExpression implements Expression
{
    public function __construct(private float $value, private FileSpan $span, private ?string $unit = null)
    {
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitNumberExpression($this);
    }

    public function __toString(): string
    {
        return (string) SassNumber::create($this->value, $this->unit);
    }
}

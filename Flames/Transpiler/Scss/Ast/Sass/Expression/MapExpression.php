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
 * A map literal.
 *
 * @internal
 */
final readonly class MapExpression implements Expression
{
    /**
     * @param list<array{Expression, Expression}> $pairs
     */
    public function __construct(private array $pairs, private FileSpan $span)
    {
    }

    /**
     * @return list<array{Expression, Expression}>
     */
    public function getPairs(): array
    {
        return $this->pairs;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitMapExpression($this);
    }

    public function __toString(): string
    {
        return '(' . implode(', ', array_map(fn($pair) => $pair[0] . ': ' . $pair[1], $this->pairs)) . ')';
    }
}

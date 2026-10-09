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
 * A null literal.
 *
 * @internal
 */
final readonly class NullExpression implements Expression
{
    public function __construct(private FileSpan $span)
    {
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitNullExpression($this);
    }

    public function __toString(): string
    {
        return 'null';
    }
}

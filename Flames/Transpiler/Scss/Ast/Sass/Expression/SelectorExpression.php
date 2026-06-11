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
 * A parent selector reference, `&`.
 *
 * @internal
 */
final class SelectorExpression implements Expression
{
    private readonly FileSpan $span;

    public function __construct(FileSpan $span)
    {
        $this->span = $span;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitSelectorExpression($this);
    }

    public function __toString(): string
    {
        return '&';
    }
}

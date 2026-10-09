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

namespace Flames\Transpiler\Scss\Ast\Sass\Statement;

use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A `@warn` rule.
 *
 * This prints a Sass value—usually a string—to warn the user of something.
 *
 * @internal
 */
final readonly class WarnRule implements Statement
{
    public function __construct(private Expression $expression, private FileSpan $span)
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

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitWarnRule($this);
    }

    public function __toString(): string
    {
        return '@warn ' . $this->expression . ';';
    }
}

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
 * A `@while` rule.
 *
 * This repeatedly executes a block of code as long as a statement evaluates to
 * `true`.
 *
 * @extends ParentStatement<Statement[]>
 *
 * @internal
 */
final class WhileRule extends ParentStatement
{
    /**
     * @param Statement[] $children
     */
    public function __construct(private readonly Expression $condition, array $children, private readonly FileSpan $span)
    {
        parent::__construct($children);
    }

    public function getCondition(): Expression
    {
        return $this->condition;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitWhileRule($this);
    }

    public function __toString(): string
    {
        return '@while ' . $this->condition . ' {' . implode(' ', $this->getChildren()) . '}';
    }
}

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

use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A `@supports` rule.
 *
 * @extends ParentStatement<Statement[]>
 *
 * @internal
 */
final class SupportsRule extends ParentStatement
{
    /**
     * @param Statement[] $children
     */
    public function __construct(private readonly SupportsCondition $condition, array $children, private readonly FileSpan $span)
    {
        parent::__construct($children);
    }

    public function getCondition(): SupportsCondition
    {
        return $this->condition;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitSupportsRule($this);
    }

    public function __toString(): string
    {
        return '@supports ' . $this->condition . ' {' . implode(' ', $this->getChildren()) . '}';
    }
}

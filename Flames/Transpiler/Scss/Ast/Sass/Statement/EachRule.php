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
 * An `@each` rule.
 *
 * This iterates over values in a list or map.
 *
 * @extends ParentStatement<Statement[]>
 *
 * @internal
 */
final class EachRule extends ParentStatement
{
    /**
     * @param list<string> $variables
     * @param Statement[] $children
     */
    public function __construct(private readonly array $variables, private readonly Expression $list, array $children, private readonly FileSpan $span)
    {
        parent::__construct($children);
    }

    /**
     * @return list<string>
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    public function getList(): Expression
    {
        return $this->list;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitEachRule($this);
    }

    public function __toString(): string
    {
        return '@each ' . implode(', ', array_map(fn($variable) => '$' . $variable, $this->variables)) . ' in ' . $this->list . ' {' . implode(' ', $this->getChildren()) . '}';
    }
}

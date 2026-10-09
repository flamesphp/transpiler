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

use Flames\Transpiler\Scss\Ast\Sass\Interpolation;
use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A `@at-root` rule.
 *
 * This moves it contents "up" the tree through parent nodes.
 *
 * @extends ParentStatement<Statement[]>
 *
 * @internal
 */
final class AtRootRule extends ParentStatement
{
    /**
     * @param Statement[] $children
     */
    public function __construct(array $children, private readonly FileSpan $span, private readonly ?Interpolation $query = null)
    {
        parent::__construct($children);
    }

    /**
     * The query specifying which statements this should move its contents through.
     */
    public function getQuery(): ?Interpolation
    {
        return $this->query;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitAtRootRule($this);
    }

    public function __toString(): string
    {
        $buffer = '@at-root ';
        if ($this->query !== null) {
            $buffer .= $this->query . ' ';
        }

        return $buffer . '{' . implode(' ', $this->getChildren()) . '}';
    }
}

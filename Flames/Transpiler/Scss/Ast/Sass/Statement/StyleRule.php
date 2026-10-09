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
 * A style rule.
 *
 * This applies style declarations to elements that match a given selector.
 *
 * @extends ParentStatement<Statement[]>
 *
 * @internal
 */
final class StyleRule extends ParentStatement
{
    /**
     * @param Statement[] $children
     */
    public function __construct(private readonly Interpolation $selector, array $children, private readonly FileSpan $span)
    {
        parent::__construct($children);
    }

    /**
     * The selector to which the declaration will be applied.
     *
     * This is only parsed after the interpolation has been resolved.
     */
    public function getSelector(): Interpolation
    {
        return $this->selector;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitStyleRule($this);
    }

    public function __toString(): string
    {
        return $this->selector . ' {' . implode(' ', $this->getChildren()) . '}';
    }
}

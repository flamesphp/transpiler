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

namespace Flames\Transpiler\Scss\Ast\Css;

use Flames\Transpiler\Scss\Visitor\ModifiableCssVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A modifiable version of {@see CssStylesheet} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssStylesheet extends ModifiableCssParentNode implements CssStylesheet
{
    /**
     * @param list<ModifiableCssNode> $children
     */
    public function __construct(private readonly FileSpan $span, array $children = [])
    {
        parent::__construct($children);
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ModifiableCssVisitor $visitor)
    {
        return $visitor->visitCssStylesheet($this);
    }

    public function equalsIgnoringChildren(ModifiableCssNode $other): bool
    {
        return $other instanceof ModifiableCssStylesheet;
    }

    public function copyWithoutChildren(): ModifiableCssStylesheet
    {
        return new ModifiableCssStylesheet($this->span);
    }
}

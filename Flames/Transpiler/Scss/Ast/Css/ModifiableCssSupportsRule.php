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

use Flames\Transpiler\Scss\Util\EquatableUtil;
use Flames\Transpiler\Scss\Visitor\ModifiableCssVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A modifiable version of {@see CssSupportsRule} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssSupportsRule extends ModifiableCssParentNode implements CssSupportsRule
{
    /**
     * @param CssValue<string> $condition
     */
    public function __construct(private readonly CssValue $condition, private readonly FileSpan $span)
    {
        parent::__construct();
    }

    public function getCondition(): CssValue
    {
        return $this->condition;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ModifiableCssVisitor $visitor)
    {
        return $visitor->visitCssSupportsRule($this);
    }

    public function equalsIgnoringChildren(ModifiableCssNode $other): bool
    {
        return $other instanceof ModifiableCssSupportsRule && EquatableUtil::equals($this->condition, $other->condition);
    }

    public function copyWithoutChildren(): ModifiableCssSupportsRule
    {
        return new ModifiableCssSupportsRule($this->condition, $this->span);
    }
}

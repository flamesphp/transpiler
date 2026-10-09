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
 * A modifiable version of {@see CssKeyframeBlock} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssKeyframeBlock extends ModifiableCssParentNode implements CssKeyframeBlock
{
    /**
     * @param CssValue<list<string>> $selector
     */
    public function __construct(private readonly CssValue $selector, private readonly FileSpan $span)
    {
        parent::__construct();
    }

    public function getSelector(): CssValue
    {
        return $this->selector;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ModifiableCssVisitor $visitor)
    {
        return $visitor->visitCssKeyframeBlock($this);
    }

    public function equalsIgnoringChildren(ModifiableCssNode $other): bool
    {
        return $other instanceof ModifiableCssKeyframeBlock && EquatableUtil::listEquals($this->selector->getValue(), $other->selector->getValue());
    }

    public function copyWithoutChildren(): ModifiableCssKeyframeBlock
    {
        return new ModifiableCssKeyframeBlock($this->selector, $this->span);
    }
}

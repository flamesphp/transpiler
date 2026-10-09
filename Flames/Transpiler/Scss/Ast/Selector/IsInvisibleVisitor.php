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

namespace Flames\Transpiler\Scss\Ast\Selector;

use Flames\Transpiler\Scss\Visitor\AnySelectorVisitor;

/**
 * The visitor used to implement {@see Selector::isInvisible}.
 *
 * @internal
 */
final class IsInvisibleVisitor extends AnySelectorVisitor
{
    public function __construct(
        /**
         * Whether to consider selectors with bogus combinators invisible.
         */
        private readonly bool $includeBogus
    )
    {
    }

    public function visitSelectorList(SelectorList $list): bool
    {
        return array_all($list->getComponents(), fn($complex) => $this->visitComplexSelector($complex));
    }

    public function visitComplexSelector(ComplexSelector $complex): bool
    {
        return parent::visitComplexSelector($complex) || ($this->includeBogus && $complex->isBogusOtherThanLeadingCombinator());
    }

    public function visitPlaceholderSelector(PlaceholderSelector $placeholder): bool
    {
        return true;
    }

    public function visitPseudoSelector(PseudoSelector $pseudo): bool
    {
        $selector = $pseudo->getSelector();

        if ($selector === null) {
            return false;
        }

        // We don't consider `:not(%foo)` to be invisible because, semantically, it
        // means "doesn't match this selector that matches nothing", so it's
        // equivalent to *. If the entire compound selector is composed of `:not`s
        // with invisible lists, the serializer emits it as `*`.
        return $pseudo->getName() === 'not' ? ($this->includeBogus && $selector->isBogus()) : $selector->accept($this);
    }
}

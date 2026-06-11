<?php

namespace Flames\Transpiler\Scss\Ast\Selector;

use Flames\Transpiler\Scss\Visitor\SelectorSearchVisitor;

/**
 * A visitor for finding the first {@see ParentSelector} in a given selector.
 *
 * @template-extends SelectorSearchVisitor<ParentSelector>
 *
 * @internal
 */
final class ParentSelectorVisitor extends SelectorSearchVisitor
{
    public function visitParentSelector(ParentSelector $selector): ParentSelector
    {
        return $selector;
    }
}

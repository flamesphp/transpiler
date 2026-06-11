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

namespace Flames\Transpiler\Scss\Visitor;

use Flames\Transpiler\Scss\Ast\Selector\AttributeSelector;
use Flames\Transpiler\Scss\Ast\Selector\ClassSelector;
use Flames\Transpiler\Scss\Ast\Selector\ComplexSelector;
use Flames\Transpiler\Scss\Ast\Selector\CompoundSelector;
use Flames\Transpiler\Scss\Ast\Selector\IDSelector;
use Flames\Transpiler\Scss\Ast\Selector\ParentSelector;
use Flames\Transpiler\Scss\Ast\Selector\PlaceholderSelector;
use Flames\Transpiler\Scss\Ast\Selector\PseudoSelector;
use Flames\Transpiler\Scss\Ast\Selector\SelectorList;
use Flames\Transpiler\Scss\Ast\Selector\TypeSelector;
use Flames\Transpiler\Scss\Ast\Selector\UniversalSelector;

/**
 * An interface for visitors that traverse selectors.
 *
 * @internal
 *
 * @template T
 */
interface SelectorVisitor
{
    /**
     * @return T
     */
    public function visitAttributeSelector(AttributeSelector $attribute);

    /**
     * @return T
     */
    public function visitClassSelector(ClassSelector $klass);

    /**
     * @return T
     */
    public function visitComplexSelector(ComplexSelector $complex);

    /**
     * @return T
     */
    public function visitCompoundSelector(CompoundSelector $compound);

    /**
     * @return T
     */
    public function visitIDSelector(IDSelector $id);

    /**
     * @return T
     */
    public function visitParentSelector(ParentSelector $parent);

    /**
     * @return T
     */
    public function visitPlaceholderSelector(PlaceholderSelector $placeholder);

    /**
     * @return T
     */
    public function visitPseudoSelector(PseudoSelector $pseudo);

    /**
     * @return T
     */
    public function visitSelectorList(SelectorList $list);

    /**
     * @return T
     */
    public function visitTypeSelector(TypeSelector $type);

    /**
     * @return T
     */
    public function visitUniversalSelector(UniversalSelector $universal);
}

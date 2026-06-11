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

use Flames\Transpiler\Scss\Ast\Css\CssAtRule;
use Flames\Transpiler\Scss\Ast\Css\CssComment;
use Flames\Transpiler\Scss\Ast\Css\CssDeclaration;
use Flames\Transpiler\Scss\Ast\Css\CssImport;
use Flames\Transpiler\Scss\Ast\Css\CssKeyframeBlock;
use Flames\Transpiler\Scss\Ast\Css\CssMediaRule;
use Flames\Transpiler\Scss\Ast\Css\CssStyleRule;
use Flames\Transpiler\Scss\Ast\Css\CssStylesheet;
use Flames\Transpiler\Scss\Ast\Css\CssSupportsRule;

/**
 * An interface for visitors that traverse CSS statements.
 *
 * @internal
 *
 * @template T
 * @template-extends ModifiableCssVisitor<T>
 */
interface CssVisitor extends ModifiableCssVisitor
{
    /**
     * @return T
     */
    public function visitCssAtRule(CssAtRule $node);

    /**
     * @return T
     */
    public function visitCssComment(CssComment $node);

    /**
     * @return T
     */
    public function visitCssDeclaration(CssDeclaration $node);

    /**
     * @return T
     */
    public function visitCssImport(CssImport $node);

    /**
     * @return T
     */
    public function visitCssKeyframeBlock(CssKeyframeBlock $node);

    /**
     * @return T
     */
    public function visitCssMediaRule(CssMediaRule $node);

    /**
     * @return T
     */
    public function visitCssStyleRule(CssStyleRule $node);

    /**
     * @return T
     */
    public function visitCssStylesheet(CssStylesheet $node);

    /**
     * @return T
     */
    public function visitCssSupportsRule(CssSupportsRule $node);
}

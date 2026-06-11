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
use Flames\Transpiler\Scss\Ast\Css\CssNode;
use Flames\Transpiler\Scss\Ast\Css\CssStyleRule;
use Flames\Transpiler\Scss\Ast\Css\CssStylesheet;
use Flames\Transpiler\Scss\Ast\Css\CssSupportsRule;
use Flames\Transpiler\Scss\Util\IterableUtil;

/**
 * A visitor that visits each statement in a CSS AST and returns `true` if all
 * of the individual methods return `true`.
 *
 * Each method returns `false` by default.
 *
 * @template-implements CssVisitor<bool>
 * @internal
 */
abstract class EveryCssVisitor implements CssVisitor
{
    public function visitCssAtRule(CssAtRule $node): bool
    {
        return IterableUtil::every($node->getChildren(), fn (CssNode $child) => $child->accept($this));
    }

    public function visitCssComment(CssComment $node): bool
    {
        return false;
    }

    public function visitCssDeclaration(CssDeclaration $node): bool
    {
        return false;
    }

    public function visitCssImport(CssImport $node): bool
    {
        return false;
    }

    public function visitCssKeyframeBlock(CssKeyframeBlock $node): bool
    {
        return IterableUtil::every($node->getChildren(), fn (CssNode $child) => $child->accept($this));
    }

    public function visitCssMediaRule(CssMediaRule $node): bool
    {
        return IterableUtil::every($node->getChildren(), fn (CssNode $child) => $child->accept($this));
    }

    public function visitCssStyleRule(CssStyleRule $node): bool
    {
        return IterableUtil::every($node->getChildren(), fn (CssNode $child) => $child->accept($this));
    }

    public function visitCssStylesheet(CssStylesheet $node): bool
    {
        return IterableUtil::every($node->getChildren(), fn (CssNode $child) => $child->accept($this));
    }

    public function visitCssSupportsRule(CssSupportsRule $node): bool
    {
        return IterableUtil::every($node->getChildren(), fn (CssNode $child) => $child->accept($this));
    }
}

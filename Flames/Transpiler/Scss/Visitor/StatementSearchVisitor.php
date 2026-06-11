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

use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Ast\Sass\Statement\AtRootRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\AtRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\CallableDeclaration;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ContentBlock;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ContentRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\DebugRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\Declaration;
use Flames\Transpiler\Scss\Ast\Sass\Statement\EachRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ErrorRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ExtendRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ForRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\FunctionRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\IfClause;
use Flames\Transpiler\Scss\Ast\Sass\Statement\IfRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ImportRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\IncludeRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\LoudComment;
use Flames\Transpiler\Scss\Ast\Sass\Statement\MediaRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\MixinRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ParentStatement;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ReturnRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\SilentComment;
use Flames\Transpiler\Scss\Ast\Sass\Statement\StyleRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\Stylesheet;
use Flames\Transpiler\Scss\Ast\Sass\Statement\SupportsRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\VariableDeclaration;
use Flames\Transpiler\Scss\Ast\Sass\Statement\WarnRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\WhileRule;
use Flames\Transpiler\Scss\Util\IterableUtil;

/**
 * A StatementVisitor whose `visit*` methods default to returning `null`, but
 * which returns the first non-`null` value returned by any method.
 *
 * This can be extended to find the first instance of particular nodes in the
 * AST.
 *
 * @internal
 *
 * @template T
 * @template-implements StatementVisitor<T|null>
 */
abstract class StatementSearchVisitor implements StatementVisitor
{
    public function visitAtRootRule(AtRootRule $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    public function visitAtRule(AtRule $node)
    {
        if ($node->getChildren() !== null) {
            return $this->visitChildren($node->getChildren());
        }

        return null;
    }

    public function visitContentBlock(ContentBlock $node)
    {
        return $this->visitCallableDeclaration($node);
    }

    public function visitContentRule(ContentRule $node)
    {
        return null;
    }

    public function visitDebugRule(DebugRule $node)
    {
        return null;
    }

    public function visitDeclaration(Declaration $node)
    {
        if ($node->getChildren() !== null) {
            return $this->visitChildren($node->getChildren());
        }

        return null;
    }

    public function visitEachRule(EachRule $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    public function visitErrorRule(ErrorRule $node)
    {
        return null;
    }

    public function visitExtendRule(ExtendRule $node)
    {
        return null;
    }

    public function visitForRule(ForRule $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    public function visitFunctionRule(FunctionRule $node)
    {
        return $this->visitCallableDeclaration($node);
    }

    public function visitIfRule(IfRule $node)
    {
        $value = IterableUtil::search($node->getClauses(), fn(IfClause $clause) => IterableUtil::search($clause->getChildren(), fn(Statement $child) => $child->accept($this)));

        if ($node->getLastClause() !== null) {
            $value ??= IterableUtil::search($node->getLastClause()->getChildren(), fn(Statement $child) => $child->accept($this));
        }

        return $value;
    }

    public function visitImportRule(ImportRule $node)
    {
        return null;
    }

    public function visitIncludeRule(IncludeRule $node)
    {
        if ($node->getContent() !== null) {
            return $this->visitContentBlock($node->getContent());
        }

        return null;
    }

    public function visitLoudComment(LoudComment $node)
    {
        return null;
    }

    public function visitMediaRule(MediaRule $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    public function visitMixinRule(MixinRule $node)
    {
        return $this->visitCallableDeclaration($node);
    }

    public function visitReturnRule(ReturnRule $node)
    {
        return null;
    }

    public function visitSilentComment(SilentComment $node)
    {
        return null;
    }

    public function visitStyleRule(StyleRule $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    public function visitStylesheet(Stylesheet $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    public function visitSupportsRule(SupportsRule $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    public function visitVariableDeclaration(VariableDeclaration $node)
    {
        return null;
    }

    public function visitWarnRule(WarnRule $node)
    {
        return null;
    }

    public function visitWhileRule(WhileRule $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    /**
     * Visits each of $node's expressions and children.
     *
     * The default implementations of {@see visitFunctionRule} and {@see visitMixinRule}
     * call this.
     *
     * @return T|null
     */
    protected function visitCallableDeclaration(CallableDeclaration $node)
    {
        return $this->visitChildren($node->getChildren());
    }

    /**
     * Visits each child in $children.
     *
     * The default implementation of the visit methods for all {@see ParentStatement}s
     * call this.
     *
     * @param Statement[] $children
     *
     * @return T|null
     */
    protected function visitChildren(array $children)
    {
        return IterableUtil::search($children, fn (Statement $child) => $child->accept($this));
    }
}

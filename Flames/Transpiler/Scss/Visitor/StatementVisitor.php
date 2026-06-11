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

use Flames\Transpiler\Scss\Ast\Sass\Statement\AtRootRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\AtRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ContentBlock;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ContentRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\DebugRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\Declaration;
use Flames\Transpiler\Scss\Ast\Sass\Statement\EachRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ErrorRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ExtendRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ForRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\FunctionRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\IfRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ImportRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\IncludeRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\LoudComment;
use Flames\Transpiler\Scss\Ast\Sass\Statement\MediaRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\MixinRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\ReturnRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\SilentComment;
use Flames\Transpiler\Scss\Ast\Sass\Statement\StyleRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\Stylesheet;
use Flames\Transpiler\Scss\Ast\Sass\Statement\SupportsRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\VariableDeclaration;
use Flames\Transpiler\Scss\Ast\Sass\Statement\WarnRule;
use Flames\Transpiler\Scss\Ast\Sass\Statement\WhileRule;

/**
 * An interface for visitors that traverse SassScript statements.
 *
 * @internal
 *
 * @template T
 */
interface StatementVisitor
{
    /**
     * @return T
     */
    public function visitAtRootRule(AtRootRule $node);

    /**
     * @return T
     */
    public function visitAtRule(AtRule $node);

    /**
     * @return T
     */
    public function visitContentBlock(ContentBlock $node);

    /**
     * @return T
     */
    public function visitContentRule(ContentRule $node);

    /**
     * @return T
     */
    public function visitDebugRule(DebugRule $node);

    /**
     * @return T
     */
    public function visitDeclaration(Declaration $node);

    /**
     * @return T
     */
    public function visitEachRule(EachRule $node);

    /**
     * @return T
     */
    public function visitErrorRule(ErrorRule $node);

    /**
     * @return T
     */
    public function visitExtendRule(ExtendRule $node);

    /**
     * @return T
     */
    public function visitForRule(ForRule $node);

    /**
     * @return T
     */
    public function visitFunctionRule(FunctionRule $node);

    /**
     * @return T
     */
    public function visitIfRule(IfRule $node);

    /**
     * @return T
     */
    public function visitImportRule(ImportRule $node);

    /**
     * @return T
     */
    public function visitIncludeRule(IncludeRule $node);

    /**
     * @return T
     */
    public function visitLoudComment(LoudComment $node);

    /**
     * @return T
     */
    public function visitMediaRule(MediaRule $node);

    /**
     * @return T
     */
    public function visitMixinRule(MixinRule $node);

    /**
     * @return T
     */
    public function visitReturnRule(ReturnRule $node);

    /**
     * @return T
     */
    public function visitSilentComment(SilentComment $node);

    /**
     * @return T
     */
    public function visitStyleRule(StyleRule $node);

    /**
     * @return T
     */
    public function visitStylesheet(Stylesheet $node);

    /**
     * @return T
     */
    public function visitSupportsRule(SupportsRule $node);

    /**
     * @return T
     */
    public function visitVariableDeclaration(VariableDeclaration $node);

    /**
     * @return T
     */
    public function visitWarnRule(WarnRule $node);

    /**
     * @return T
     */
    public function visitWhileRule(WhileRule $node);
}

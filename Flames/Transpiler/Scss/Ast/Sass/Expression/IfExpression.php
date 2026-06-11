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

namespace Flames\Transpiler\Scss\Ast\Sass\Expression;

use Flames\Transpiler\Scss\Ast\Sass\ArgumentDeclaration;
use Flames\Transpiler\Scss\Ast\Sass\ArgumentInvocation;
use Flames\Transpiler\Scss\Ast\Sass\CallableInvocation;
use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use SourceSpan\FileSpan;

/**
 * A ternary expression.
 *
 * This is defined as a separate syntactic construct rather than a normal
 * function because only one of the `$if-true` and `$if-false` arguments are
 * evaluated.
 *
 * @internal
 */
final class IfExpression implements Expression, CallableInvocation
{
    /**
     * The arguments passed to `if()`.
     */
    private readonly ArgumentInvocation $arguments;

    private readonly FileSpan $span;

    private static ?ArgumentDeclaration $declaration = null;

    public function __construct(ArgumentInvocation $arguments, FileSpan $span)
    {
        $this->span = $span;
        $this->arguments = $arguments;
    }

    /**
     * The declaration of `if()`, as though it were a normal function.
     */
    public static function getDeclaration(): ArgumentDeclaration
    {
        if (self::$declaration === null) {
            self::$declaration = ArgumentDeclaration::parse('@function if($condition, $if-true, $if-false) {');
        }

        return self::$declaration;
    }

    public function getArguments(): ArgumentInvocation
    {
        return $this->arguments;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitIfExpression($this);
    }

    public function __toString(): string
    {
        return 'if' . $this->arguments;
    }
}

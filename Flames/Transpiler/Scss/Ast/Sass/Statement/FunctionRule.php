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

namespace Flames\Transpiler\Scss\Ast\Sass\Statement;

use Flames\Transpiler\Scss\Ast\Sass\SassDeclaration;
use Flames\Transpiler\Scss\Util\SpanUtil;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A function declaration.
 *
 * This declares a function that's invoked using normal CSS function syntax.
 *
 * @internal
 */
final class FunctionRule extends CallableDeclaration implements SassDeclaration
{
    public function getNameSpan(): FileSpan
    {
        return SpanUtil::initialIdentifier(SpanUtil::withoutInitialAtRule($this->getSpan()));
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitFunctionRule($this);
    }

    public function __toString(): string
    {
        return '@function ' . $this->getName() . '(' . $this->getArguments() . ') {' . implode(' ', $this->getChildren()) . '}';
    }
}

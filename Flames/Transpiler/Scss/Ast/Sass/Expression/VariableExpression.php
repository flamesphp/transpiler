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

use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Ast\Sass\SassReference;
use Flames\Transpiler\Scss\Util\SpanUtil;
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A Sass variable.
 *
 * @internal
 */
final readonly class VariableExpression implements Expression, SassReference
{
    public function __construct(
        /**
         * The name of this variable, with underscores converted to hyphens.
         */
        private string $name,
        private FileSpan $span,
        /**
         * The namespace of the variable being referenced, or `null` if it's
         * referenced without a namespace.
         */
        private ?string $namespace = null
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function getNameSpan(): FileSpan
    {
        if ($this->namespace === null) {
            return $this->span;
        }

        return SpanUtil::withoutNamespace($this->span);
    }

    public function getNamespaceSpan(): ?FileSpan
    {
        if ($this->namespace === null) {
            return null;
        }

        return SpanUtil::initialIdentifier($this->span);
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitVariableExpression($this);
    }

    public function __toString(): string
    {
        return $this->span->getText();
    }
}

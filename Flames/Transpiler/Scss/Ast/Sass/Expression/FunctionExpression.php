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

use Flames\Transpiler\Scss\Ast\Sass\ArgumentInvocation;
use Flames\Transpiler\Scss\Ast\Sass\CallableInvocation;
use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Ast\Sass\SassReference;
use Flames\Transpiler\Scss\Util\SpanUtil;
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A function invocation.
 *
 * This may be a plain CSS function or a Sass function,  but may not include
 * interpolation.
 *
 * @internal
 */
final readonly class FunctionExpression implements Expression, CallableInvocation, SassReference
{
    /**
     * The name of the function being invoked, with underscores converted to
     * hyphens.
     *
     * If this function is a plain CSS function, use {@see $originalName} instead.
     */
    private string $name;

    public function __construct(/**
     * The name of the function being invoked, with underscores left as-is.
     */
    private string $originalName, /**
     * The arguments to pass to the function.
     */
    private ArgumentInvocation $arguments, private FileSpan $span, /**
     * The namespace of the function being invoked, or `null` if it's invoked
     * without a namespace.
     */
    private ?string $namespace = null)
    {
        $this->name = str_replace('_', '-', $this->originalName);
    }

    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    /**
     * The name of the function being invoked, with underscores converted to
     * hyphens.
     *
     * If this function is a plain CSS function, use {@see getOriginalName} instead.
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getArguments(): ArgumentInvocation
    {
        return $this->arguments;
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
            return SpanUtil::initialIdentifier($this->span);
        }

        return SpanUtil::initialIdentifier(SpanUtil::withoutNamespace($this->span));
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
        return $visitor->visitFunctionExpression($this);
    }

    public function __toString(): string
    {
        $buffer = '';

        if ($this->namespace !== null) {
            $buffer .= $this->namespace . '.';
        }

        $buffer .= $this->originalName . $this->arguments;

        return $buffer;
    }
}

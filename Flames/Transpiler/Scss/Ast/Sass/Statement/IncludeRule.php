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

use Flames\Transpiler\Scss\Ast\Sass\ArgumentInvocation;
use Flames\Transpiler\Scss\Ast\Sass\CallableInvocation;
use Flames\Transpiler\Scss\Ast\Sass\SassReference;
use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Util\SpanUtil;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A mixin invocation.
 *
 * @internal
 */
final readonly class IncludeRule implements Statement, CallableInvocation, SassReference
{
    private string $name;

    public function __construct(private string $originalName, private ArgumentInvocation $arguments, private FileSpan $span, private ?string $namespace = null, private ?ContentBlock $content = null)
    {
        $this->name = str_replace('_', '-', $this->originalName);
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * The original name of the mixin being invoked, without underscores
     * converted to hyphens.
     */
    public function getOriginalName(): string
    {
        return $this->originalName;
    }

    public function getArguments(): ArgumentInvocation
    {
        return $this->arguments;
    }

    public function getContent(): ?ContentBlock
    {
        return $this->content;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function getSpanWithoutContent(): FileSpan
    {
        if ($this->content === null) {
            return $this->span;
        }

        return SpanUtil::trim($this->span->getFile()->span($this->span->getStart()->getOffset(), $this->arguments->getSpan()->getEnd()->getOffset()));
    }

    public function getNameSpan(): FileSpan
    {
        $startSpan = $this->span->getText()[0] === '+' ? SpanUtil::trimLeft($this->span->subspan(1)) : SpanUtil::withoutInitialAtRule($this->span);

        if ($this->namespace !== null) {
            $startSpan = SpanUtil::withoutNamespace($startSpan);
        }

        return SpanUtil::initialIdentifier($startSpan);
    }

    public function getNamespaceSpan(): ?FileSpan
    {
        if ($this->namespace === null) {
            return null;
        }

        $startSpan = $this->span->getText()[0] === '+'
            ? SpanUtil::trimLeft($this->span->subspan(1))
            : SpanUtil::withoutInitialAtRule($this->span);

        return SpanUtil::initialIdentifier($startSpan);
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitIncludeRule($this);
    }

    public function __toString(): string
    {
        $buffer = '@include ';

        if ($this->namespace !== null) {
            $buffer .= $this->namespace . '.';
        }
        $buffer .= $this->name;

        if (!$this->arguments->isEmpty()) {
            $buffer .= "($this->arguments)";
        }

        $buffer .= $this->content === null ? ';' : ' ' . $this->content;

        return $buffer;
    }
}

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

namespace Flames\Transpiler\Scss\Ast\Sass;

use Flames\Transpiler\Scss\Ast\Sass\Expression\ListExpression;
use Flames\Transpiler\Scss\Value\ListSeparator;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A set of arguments passed in to a function or mixin.
 *
 * @internal
 */
final readonly class ArgumentInvocation implements SassNode
{
    private ?Expression $rest;

    private ?Expression $keywordRest;

    /**
     * @param list<Expression>          $positional
     * @param array<string, Expression> $named
     */
    public function __construct(private array $positional, private array $named, private FileSpan $span, ?Expression $rest = null, ?Expression $keywordRest = null)
    {
        assert($keywordRest === null || $rest !== null);
        $this->rest = $rest;
        $this->keywordRest = $keywordRest;
    }

    public static function createEmpty(FileSpan $span): ArgumentInvocation
    {
        return new self([], [], $span);
    }

    public function isEmpty(): bool
    {
        return \count($this->positional) === 0 && \count($this->named) === 0 && $this->rest === null;
    }

    /**
     * @return list<Expression>
     */
    public function getPositional(): array
    {
        return $this->positional;
    }

    /**
     * @return array<string, Expression>
     */
    public function getNamed(): array
    {
        return $this->named;
    }

    public function getRest(): ?Expression
    {
        return $this->rest;
    }

    public function getKeywordRest(): ?Expression
    {
        return $this->keywordRest;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        $parts = [];
        foreach ($this->positional as $argument) {
            $parts[] = $this->parenthesizeArgument($argument);
        }
        foreach ($this->named as $name => $arg) {
            $parts[] = "\$$name: {$this->parenthesizeArgument($arg)}";
        }
        if ($this->rest !== null) {
            $parts[] = "{$this->parenthesizeArgument($this->rest)}...";
        }
        if ($this->keywordRest !== null) {
            $parts[] = "{$this->parenthesizeArgument($this->keywordRest)}...";
        }

        return '(' . implode(', ', $parts) . ')';
    }

    private function parenthesizeArgument(Expression $argument): string
    {
        if ($argument instanceof ListExpression && $argument->getSeparator() === ListSeparator::COMMA && !$argument->hasBrackets() && \count($argument->getContents()) > 1) {
            return "($argument)";
        }

        return (string) $argument;
    }
}

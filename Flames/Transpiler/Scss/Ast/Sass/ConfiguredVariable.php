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

use Flames\Transpiler\Scss\Util\SpanUtil;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A variable configured by a `with` clause in a `@use` or `@forward` rule.
 *
 * @internal
 */
final readonly class ConfiguredVariable implements SassNode, SassDeclaration
{
    public function __construct(private string $name, private Expression $expression, private FileSpan $span, private bool $guarded = false)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExpression(): Expression
    {
        return $this->expression;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function isGuarded(): bool
    {
        return $this->guarded;
    }

    public function getNameSpan(): FileSpan
    {
        return SpanUtil::initialIdentifier($this->span, 1);
    }

    public function __toString(): string
    {
        return '$' . $this->name . ': ' . $this->expression . ($this->guarded ? ' !default' : '');
    }
}

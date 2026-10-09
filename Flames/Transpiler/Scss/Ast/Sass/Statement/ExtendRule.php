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

use Flames\Transpiler\Scss\Ast\Sass\Interpolation;
use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An `@extend` rule.
 *
 * This gives one selector all the styling of another.
 *
 * @internal
 */
final readonly class ExtendRule implements Statement
{
    public function __construct(private Interpolation $selector, private FileSpan $span, private bool $optional = false)
    {
    }

    public function getSelector(): Interpolation
    {
        return $this->selector;
    }

    /**
     * Whether this is an optional extension.
     *
     * If an extension isn't optional, it will emit an error if it doesn't match
     * any selectors.
     */
    public function isOptional(): bool
    {
        return $this->optional;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitExtendRule($this);
    }

    public function __toString(): string
    {
        return '@extend ' . $this->selector . ($this->optional ? ' !optional' : '') . ';';
    }
}

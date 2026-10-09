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

namespace Flames\Transpiler\Scss\Ast\Css;

use Flames\Transpiler\Scss\Ast\AstNode;
use Flames\Transpiler\Scss\Ast\Selector\Combinator;
use Flames\Transpiler\Scss\Util\Equatable;
use Flames\Transpiler\Scss\Util\EquatableUtil;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A value in a plain CSS tree.
 *
 * This is used to associate a span with a value that doesn't otherwise track
 * its span. It has value equality semantics.
 *
 * @template-covariant T of string|\Stringable|array<string|\Stringable>|Combinator|null
 *
 * @internal
 */
final readonly class CssValue implements AstNode, Equatable
{
    /**
     * @param T $value
     */
    public function __construct(private mixed $value, private FileSpan $span)
    {
    }

    /**
     * @return T
     */
    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function equals(object $other): bool
    {
        return $other instanceof CssValue && EquatableUtil::equals($this->value, $other->value);
    }

    public function __toString(): string
    {
        if ($this->value instanceof Combinator) {
            return $this->value->getText();
        }

        if (\is_array($this->value)) {
            return implode('', $this->value);
        }

        return (string) $this->value;
    }
}

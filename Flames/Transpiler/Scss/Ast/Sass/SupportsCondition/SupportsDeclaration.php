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

namespace Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;

use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Ast\Sass\Expression\StringExpression;
use Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A condition that selects for browsers where a given declaration is
 * supported.
 *
 * @internal
 */
final readonly class SupportsDeclaration implements SupportsCondition
{
    public function __construct(
        /**
         * The name of the declaration being tested.
         */
        private Expression $name,
        /**
         * The value of the declaration being tested.
         */
        private Expression $value,
        private FileSpan $span
    )
    {
    }

    public function getName(): Expression
    {
        return $this->name;
    }

    public function getValue(): Expression
    {
        return $this->value;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    /**
     * Returns whether this is a CSS Custom Property declaration.
     *
     * Note that this can return `false` for declarations that will ultimately be
     * serialized as custom properties if they aren't *parsed as* custom
     * properties, such as `#{--foo}: ...`.
     *
     * If this is `true`, then `value` will be a {@see StringExpression}.
     */
    public function isCustomProperty(): bool
    {
        return $this->name instanceof StringExpression && !$this->name->hasQuotes() && str_starts_with($this->name->getText()->getInitialPlain(), '--');
    }

    public function __toString(): string
    {
        return "($this->name: $this->value)";
    }
}

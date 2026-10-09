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

use Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An operation defining the relationship between two conditions.
 *
 * @internal
 */
final readonly class SupportsOperation implements SupportsCondition
{
    public function __construct(
        /**
         * The left-hand operand.
         */
        private SupportsCondition $left,
        /**
         * The right-hand operand.
         */
        private SupportsCondition $right,
        private string $operator,
        private FileSpan $span
    )
    {
    }

    public function getLeft(): SupportsCondition
    {
        return $this->left;
    }

    public function getRight(): SupportsCondition
    {
        return $this->right;
    }

    public function getOperator(): string
    {
        return $this->operator;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        return $this->parenthesize($this->left) . ' ' . $this->operator . ' ' . $this->parenthesize($this->right);
    }

    private function parenthesize(SupportsCondition $condition): string
    {
        if ($condition instanceof SupportsNegation || $condition instanceof SupportsOperation && $condition->operator === $this->operator) {
            return "($condition)";
        }

        return (string) $condition;
    }
}

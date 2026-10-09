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
use Flames\Transpiler\Scss\Visitor\ExpressionVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A unary operator, as in `+$var` or `not fn()`.
 *
 * @internal
 */
final readonly class UnaryOperationExpression implements Expression
{
    public function __construct(private UnaryOperator $operator, private Expression $operand, private FileSpan $span)
    {
    }

    public function getOperator(): UnaryOperator
    {
        return $this->operator;
    }

    public function getOperand(): Expression
    {
        return $this->operand;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ExpressionVisitor $visitor)
    {
        return $visitor->visitUnaryOperationExpression($this);
    }

    public function __toString(): string
    {
        $buffer = $this->operator->getOperator();
        if ($this->operator === UnaryOperator::NOT) {
            $buffer .= ' ';
        }

        $needsParens = $this->operand instanceof BinaryOperationExpression
            || $this->operand instanceof UnaryOperationExpression
            || ($this->operand instanceof ListExpression && !$this->operand->hasBrackets() && \count($this->operand->getContents()) > 1);

        if ($needsParens) {
            $buffer .= '(';
        }

        $buffer .= $this->operand;

        if ($needsParens) {
            $buffer .= ')';
        }

        return $buffer;
    }
}

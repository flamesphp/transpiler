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

namespace Flames\Transpiler\Scss\Util;

use Flames\Transpiler\Scss\Ast\Sass\ArgumentInvocation;
use Flames\Transpiler\Scss\Ast\Sass\Expression;
use Flames\Transpiler\Scss\Ast\Sass\Expression\BinaryOperationExpression;
use Flames\Transpiler\Scss\Ast\Sass\Expression\BinaryOperator;
use Flames\Transpiler\Scss\Ast\Sass\Expression\FunctionExpression;
use Flames\Transpiler\Scss\Ast\Sass\Expression\InterpolatedFunctionExpression;
use Flames\Transpiler\Scss\Ast\Sass\Expression\NumberExpression;
use Flames\Transpiler\Scss\Ast\Sass\Expression\UnaryOperationExpression;
use Flames\Transpiler\Scss\Ast\Sass\Expression\UnaryOperator;
use Flames\Transpiler\Scss\Visitor\ReplaceExpressionVisitor;

/**
 * A visitor that replaces constructs that can't be used in a calculation with
 * those that can.
 *
 * @internal
 */
final class MakeExpressionCalculationSafe extends ReplaceExpressionVisitor
{
    public function visitBinaryOperationExpression(BinaryOperationExpression $node): Expression
    {
        // `calc()` doesn't support `%` for modulo but Sass doesn't yet support the
        // `mod()` calculation function because there's no browser support, so we have
        // to work around it by wrapping the call in a Sass function.
        if ($node->getOperator() === BinaryOperator::MODULO) {
            return new FunctionExpression('max', new ArgumentInvocation([$node], [], $node->getSpan()), $node->getSpan(), 'math');
        }

        return parent::visitBinaryOperationExpression($node);
    }

    public function visitInterpolatedFunctionExpression(InterpolatedFunctionExpression $node): Expression
    {
        return $node;
    }

    public function visitUnaryOperationExpression(UnaryOperationExpression $node): Expression
    {
        switch ($node->getOperator()) {
            // `calc()` doesn't support unary operations.
            case UnaryOperator::PLUS:
                return $node->getOperand();

            case UnaryOperator::MINUS:
                return new BinaryOperationExpression(
                    BinaryOperator::TIMES,
                    new NumberExpression(-1, $node->getSpan()),
                    $node->getOperand()
                );

            // Other unary operations don't produce numbers, so keep them as-is to
            // give the user a more useful syntax error after serialization.
            default:
                return parent::visitUnaryOperationExpression($node);
        }
    }
}

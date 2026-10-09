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

namespace Flames\Transpiler\Scss\Evaluation;

use Flames\Transpiler\Scss\Ast\AstNode;
use Flames\Transpiler\Scss\Value\ListSeparator;
use Flames\Transpiler\Scss\Value\Value;

/**
 * The result of evaluating arguments to a function or mixin.
 *
 * @internal
 */
final readonly class ArgumentResults
{
    /**
     * @param list<Value>            $positional
     * @param list<AstNode>          $positionalNodes
     * @param array<string, Value>   $named
     * @param array<string, AstNode> $namedNodes
     */
    public function __construct(
        /**
         * Arguments passed by position.
         */
        private array $positional,
        /**
         * The {@see AstNode}s that hold the spans for each {@see positional} argument.
         */
        private array $positionalNodes,
        private array $named,
        /**
         * The {@see AstNode}s that hold the spans for each {@see named} argument.
         */
        private array $namedNodes,
        private ListSeparator $separator
    )
    {
    }

    /**
     * @return list<Value>
     */
    public function getPositional(): array
    {
        return $this->positional;
    }

    /**
     * @return list<AstNode>
     */
    public function getPositionalNodes(): array
    {
        return $this->positionalNodes;
    }

    /**
     * @return array<string, Value>
     */
    public function getNamed(): array
    {
        return $this->named;
    }

    /**
     * @return array<string, AstNode>
     */
    public function getNamedNodes(): array
    {
        return $this->namedNodes;
    }

    public function getSeparator(): ListSeparator
    {
        return $this->separator;
    }
}

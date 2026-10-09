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

use Flames\Transpiler\Scss\Ast\Sass\Interpolation;
use Flames\Transpiler\Scss\Ast\Sass\SupportsCondition;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A function-syntax condition.
 *
 * @internal
 */
final readonly class SupportsFunction implements SupportsCondition
{
    public function __construct(
        /**
         * The name of the function.
         */
        private Interpolation $name,
        /**
         * The arguments of the function.
         */
        private Interpolation $arguments,
        private FileSpan $span
    )
    {
    }

    public function getName(): Interpolation
    {
        return $this->name;
    }

    public function getArguments(): Interpolation
    {
        return $this->arguments;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        return "$this->name($this->arguments)";
    }
}

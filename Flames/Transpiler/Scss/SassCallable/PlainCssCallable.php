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

namespace Flames\Transpiler\Scss\SassCallable;

use Flames\Transpiler\Scss\Util\Equatable;

/**
 * A callable that emits a plain CSS function.
 *
 * This can't be used for mixins.
 *
 * @internal
 */
final readonly class PlainCssCallable implements SassCallable, Equatable
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function equals(object $other): bool
    {
        return $other instanceof PlainCssCallable && $this->name === $other->name;
    }
}

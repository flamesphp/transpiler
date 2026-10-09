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

use Flames\Transpiler\Scss\Ast\Sass\Statement\CallableDeclaration;
use Flames\Transpiler\Scss\Evaluation\Environment;

/**
 * A callback defined in the user's Sass stylesheet.
 *
 * @internal
 */
final readonly class UserDefinedCallable implements SassCallable
{
    public function __construct(private CallableDeclaration $declaration, private Environment $environment, private bool $inDependency)
    {
    }

    public function getDeclaration(): CallableDeclaration
    {
        return $this->declaration;
    }

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    public function isInDependency(): bool
    {
        return $this->inDependency;
    }

    public function getName(): string
    {
        return $this->declaration->getName();
    }
}

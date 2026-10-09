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

namespace Flames\Transpiler\Scss\Ast\Sass;

use Flames\Transpiler\Scss\Util;
use Flames\Transpiler\Scss\Util\SpanUtil;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An argument declared as part of an {@see ArgumentDeclaration}.
 *
 * @internal
 */
final readonly class Argument implements SassNode, SassDeclaration
{
    public function __construct(private string $name, private FileSpan $span, private ?Expression $defaultValue = null)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * The variable name as written in the document, without underscores
     * converted to hyphens and including the leading `$`.
     *
     * This isn't particularly efficient, and should only be used for error
     * messages.
     */
    public function getOriginalName(): string
    {
        if ($this->defaultValue === null) {
            return $this->span->getText();
        }

        return Util::declarationName($this->span);
    }

    public function getNameSpan(): FileSpan
    {
        if ($this->defaultValue === null) {
            return $this->span;
        }

        return SpanUtil::initialIdentifier($this->span, 1);
    }

    public function getDefaultValue(): ?Expression
    {
        return $this->defaultValue;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        if ($this->defaultValue === null) {
            return $this->name;
        }

        return $this->name . ': ' . $this->defaultValue;
    }
}

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

namespace Flames\Transpiler\Scss\Ast\Sass\Import;

use Flames\Transpiler\Scss\Ast\Sass\Import;
use Flames\Transpiler\Scss\Ast\Sass\Interpolation;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An import that produces a plain CSS `@import` rule.
 *
 * @internal
 */
final readonly class StaticImport implements Import
{
    public function __construct(
        /**
         * The URL for this import.
         *
         * This already contains quotes.
         */
        private Interpolation $url,
        private FileSpan $span,
        /**
         * The modifiers (such as media or supports queries) attached to this import,
         * or `null` if none are attached.
         */
        private ?Interpolation $modifiers = null
    )
    {
    }

    public function getUrl(): Interpolation
    {
        return $this->url;
    }

    public function getModifiers(): ?Interpolation
    {
        return $this->modifiers;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        $buffer = (string) $this->url;

        if ($this->modifiers !== null) {
            $buffer .= ' ' . $this->modifiers;
        }

        return $buffer;
    }
}

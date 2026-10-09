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

use Flames\Transpiler\Scss\Uri\Contracts\UriInterface;
use Flames\Transpiler\Scss\Uri\Uri;
use Flames\Transpiler\Scss\Ast\Sass\Expression\StringExpression;
use Flames\Transpiler\Scss\Ast\Sass\Import;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An import that will load a Sass file at runtime.
 *
 * @internal
 */
final readonly class DynamicImport implements Import
{
    public function __construct(
        /**
         * The URI of the file to import.
         *
         * If this is relative, it's relative to the containing file.
         */
        private string $urlString,
        private FileSpan $span
    )
    {
    }

    public function getUrl(): UriInterface
    {
        return Uri::new($this->urlString);
    }

    public function getUrlString(): string
    {
        return $this->urlString;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function __toString(): string
    {
        return StringExpression::quoteText($this->urlString);
    }
}

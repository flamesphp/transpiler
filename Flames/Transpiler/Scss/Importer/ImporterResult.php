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

namespace Flames\Transpiler\Scss\Importer;

use Flames\Transpiler\Scss\Uri\Contracts\UriInterface;
use Flames\Transpiler\Scss\Uri\Uri;
use Flames\Transpiler\Scss\Syntax;

final readonly class ImporterResult
{
    public function __construct(private string $contents, private Syntax $syntax, private ?UriInterface $sourceMapUrl = null)
    {
    }

    public function getContents(): string
    {
        return $this->contents;
    }

    /**
     * An absolute, browser-accessible URL indicating the resolved location of
     * the imported stylesheet.
     *
     * This should be a `file:` URL if one is available, but an `http:` URL is
     * acceptable as well. If no URL is supplied, a `data:` URL is generated
     * automatically from {@see contents}.
     */
    public function getSourceMapUrl(): UriInterface
    {
        return $this->sourceMapUrl ?? Uri::fromData($this->contents, '', 'charset=utf-8');
    }

    /**
     * The syntax to use to parse the stylesheet.
     */
    public function getSyntax(): Syntax
    {
        return $this->syntax;
    }
}

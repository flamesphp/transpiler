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

/**
 * @internal
 */
final readonly class CanonicalizeResult
{
    public function __construct(
        public Importer $importer,
        public UriInterface $canonicalUrl,
        public UriInterface $originalUrl,
    ) {
    }
}

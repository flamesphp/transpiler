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

use Flames\Transpiler\Scss\Ast\Css\CssStylesheet;

/**
 * The result of compiling a Sass document to a CSS tree, along with metadata
 * about the compilation process.
 *
 * @internal
 */
final readonly class EvaluateResult
{
    /**
     * @param list<string> $loadedUrls
     */
    public function __construct(private CssStylesheet $stylesheet, private array $loadedUrls)
    {
    }

    public function getStylesheet(): CssStylesheet
    {
        return $this->stylesheet;
    }

    /**
     * @return list<string>
     */
    public function getLoadedUrls(): array
    {
        return $this->loadedUrls;
    }
}

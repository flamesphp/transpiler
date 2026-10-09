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

namespace Flames\Transpiler\Scss;

final readonly class CompilationResult
{
    /**
     * @param list<string> $includedFiles
     */
    public function __construct(private string $css, private ?string $sourceMap, private array $includedFiles)
    {
    }

    public function getCss(): string
    {
        return $this->css;
    }

    /**
     * @return list<string>
     */
    public function getIncludedFiles(): array
    {
        return $this->includedFiles;
    }

    /**
     * The sourceMap content, if it was generated
     */
    public function getSourceMap(): ?string
    {
        return $this->sourceMap;
    }
}

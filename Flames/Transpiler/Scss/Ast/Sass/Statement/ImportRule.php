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

namespace Flames\Transpiler\Scss\Ast\Sass\Statement;

use Flames\Transpiler\Scss\Ast\Sass\Import;
use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * An `@import` rule.
 *
 * @internal
 */
final readonly class ImportRule implements Statement
{
    /**
     * @param list<Import> $imports
     */
    public function __construct(private array $imports, private FileSpan $span)
    {
    }

    /**
     * @return list<Import>
     */
    public function getImports(): array
    {
        return $this->imports;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitImportRule($this);
    }

    public function __toString(): string
    {
        return '@import ' . implode(', ', $this->imports) . ';';
    }
}

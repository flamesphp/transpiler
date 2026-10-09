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

use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A silent Sass-style comment.
 *
 * @internal
 */
final readonly class SilentComment implements Statement
{
    public function __construct(private string $text, private FileSpan $span)
    {
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitSilentComment($this);
    }

    public function __toString(): string
    {
        return $this->text;
    }
}

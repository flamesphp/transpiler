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

use Flames\Transpiler\Scss\Ast\Sass\Interpolation;
use Flames\Transpiler\Scss\Ast\Sass\Statement;
use Flames\Transpiler\Scss\Visitor\StatementVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A loud CSS-style comment.
 *
 * @internal
 */
final readonly class LoudComment implements Statement
{
    public function __construct(private Interpolation $text)
    {
    }

    public function getText(): Interpolation
    {
        return $this->text;
    }

    public function getSpan(): FileSpan
    {
        return $this->text->getSpan();
    }

    public function accept(StatementVisitor $visitor)
    {
        return $visitor->visitLoudComment($this);
    }

    public function __toString(): string
    {
        return (string) $this->text;
    }
}

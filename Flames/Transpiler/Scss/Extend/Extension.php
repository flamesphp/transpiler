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

namespace Flames\Transpiler\Scss\Extend;

use Flames\Transpiler\Scss\Ast\Css\CssMediaQuery;
use Flames\Transpiler\Scss\Ast\Selector\ComplexSelector;
use Flames\Transpiler\Scss\Ast\Selector\SimpleSelector;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * The state of an extension for a given extender.
 *
 * The target of the extension is represented externally, in the map that
 * contains this extender.
 *
 * @internal
 */
class Extension
{
    /**
     * The extender (such as `A` in `A {@extend B}`).
     */
    public readonly Extender $extender;

    /**
     * @param list<CssMediaQuery>|null $mediaContext
     */
    public function __construct(ComplexSelector $extender, /**
     * The selector that's being extended.
     */
    public readonly SimpleSelector $target, public readonly FileSpan $span, /**
     * The media query context to which this extension is restricted, or `null`
     * if it can apply within any context.
     */
    public readonly ?array $mediaContext = null, public readonly bool $isOptional = false)
    {
        $this->extender = Extender::forExtension($extender, $this);
    }

    public function withExtender(ComplexSelector $newExtender): Extension
    {
        return new Extension($newExtender, $this->target, $this->span, $this->mediaContext, $this->isOptional);
    }
}

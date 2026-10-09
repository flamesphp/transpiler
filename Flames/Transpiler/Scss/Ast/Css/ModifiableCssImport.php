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

namespace Flames\Transpiler\Scss\Ast\Css;

use Flames\Transpiler\Scss\Visitor\ModifiableCssVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A modifiable version of {@see CssImport} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssImport extends ModifiableCssNode implements CssImport
{
    /**
     * @param CssValue<string> $url
     * @param CssValue<string>|null $modifiers
     */
    public function __construct(
        /**
         * The URL being imported.
         *
         * This includes quotes.
         */
        private readonly CssValue $url,
        private readonly FileSpan $span,
        private readonly ?CssValue $modifiers = null
    )
    {
    }

    public function getUrl(): CssValue
    {
        return $this->url;
    }

    public function getModifiers(): ?CssValue
    {
        return $this->modifiers;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function accept(ModifiableCssVisitor $visitor)
    {
        return $visitor->visitCssImport($this);
    }
}

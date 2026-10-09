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

use Flames\Transpiler\Scss\StackTrace\Trace;
use Flames\Transpiler\Scss\Value\SassString;
use Flames\Transpiler\Scss\Value\Value;
use Flames\Transpiler\Scss\Visitor\ModifiableCssVisitor;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * A modifiable version of {@see CssDeclaration} for use in the evaluation step.
 *
 * @internal
 */
final class ModifiableCssDeclaration extends ModifiableCssNode implements CssDeclaration
{
    private readonly FileSpan $valueSpanForMap;

    /**
     * @param CssValue<string> $name
     * @param CssValue<Value> $value
     * @param list<CssStyleRule> $interleavedRules
     */
    public function __construct(private readonly CssValue $name, private readonly CssValue $value, private readonly FileSpan $span, private readonly bool $parsedAsCustomProperty, private readonly array $interleavedRules = [], private readonly ?Trace $trace = null, ?FileSpan $valueSpanForMap = null)
    {
        $this->valueSpanForMap = $valueSpanForMap ?? $this->value->getSpan();

        if ($this->parsedAsCustomProperty) {
            if (!$this->isCustomProperty()) {
                throw new \InvalidArgumentException('parsedAsCustomProperty must be false if name doesn\'t begin with "--".');
            }

            if (!$this->value->getValue() instanceof SassString) {
                throw new \InvalidArgumentException(sprintf('If parsedAsCustomProperty is true, value must contain a SassString (was %s).', get_debug_type($this->value->getValue())));
            }
        }
    }

    public function getName(): CssValue
    {
        return $this->name;
    }

    public function getValue(): CssValue
    {
        return $this->value;
    }

    public function getInterleavedRules(): array
    {
        return $this->interleavedRules;
    }

    public function getTrace(): ?Trace
    {
        return $this->trace;
    }

    public function isParsedAsCustomProperty(): bool
    {
        return $this->parsedAsCustomProperty;
    }

    public function getValueSpanForMap(): FileSpan
    {
        return $this->valueSpanForMap;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function isCustomProperty(): bool
    {
        return str_starts_with($this->name->getValue(), '--');
    }

    public function accept(ModifiableCssVisitor $visitor)
    {
        return $visitor->visitCssDeclaration($this);
    }
}

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

namespace Flames\Transpiler\Scss\Compiler;

use Flames\Transpiler\Scss\Compiler;
use Flames\Transpiler\Scss\Exception\SassScriptException;
use Flames\Transpiler\Scss\Node\Number;
use Flames\Transpiler\Scss\Type;
use Flames\Transpiler\Scss\Util\NumberUtil;
use Flames\Transpiler\Scss\Value\SassArgumentList;
use Flames\Transpiler\Scss\Value\SassBoolean;
use Flames\Transpiler\Scss\Value\SassCalculation;
use Flames\Transpiler\Scss\Value\SassColor;
use Flames\Transpiler\Scss\Value\SassFunction;
use Flames\Transpiler\Scss\Value\SassList;
use Flames\Transpiler\Scss\Value\SassMap;
use Flames\Transpiler\Scss\Value\SassMixin;
use Flames\Transpiler\Scss\Value\SassNumber;
use Flames\Transpiler\Scss\Value\SassString;
use Flames\Transpiler\Scss\Visitor\ValueVisitor;

/**
 * Converts values to the legacy representation.
 *
 * @internal
 * @template-implements ValueVisitor<array|Number>
 */
final class LegacyValueVisitor implements ValueVisitor
{
    public function visitBoolean(SassBoolean $value)
    {
        return $value->getValue() ? Compiler::$true : Compiler::$false;
    }

    public function visitCalculation(SassCalculation $value)
    {
        return [Type::T_STRING, '', $value->toCssString()];
    }

    public function visitColor(SassColor $value)
    {
        if (NumberUtil::fuzzyEquals($value->getAlpha(), 1)) {
            return [Type::T_COLOR, $value->getRed(), $value->getGreen(), $value->getBlue()];
        }

        return [Type::T_COLOR, $value->getRed(), $value->getGreen(), $value->getBlue(), $value->getAlpha()];
    }

    public function visitFunction(SassFunction $value): never
    {
        throw new SassScriptException('Functions are not supported by the legacy value API. Migrate your custom function to the new API to accept mixins as arguments.');
    }

    public function visitMixin(SassMixin $value): never
    {
        throw new SassScriptException('Mixins are not supported by the legacy value API. Migrate your custom function to the new API to accept mixins as arguments.');
    }

    public function visitList(SassList $value)
    {
        $items = [];
        foreach ($value->asList() as $item) {
            $items[] = $item->accept($this);
        }
        $list = [Type::T_LIST, $value->getSeparator()->getSeparator() ?? '', $items];
        if ($value->hasBrackets()) {
            $list['enclosing'] = 'bracket';
        }
        if ($value instanceof SassArgumentList) {
            $keywords = [];
            foreach ($value->getKeywords() as $keywordName => $keywordValue) {
                $keywords[$keywordName] = $keywordValue->accept($this);
            }
            $list[3] = $keywords;
        }

        return $list;
    }

    public function visitMap(SassMap $value)
    {
        $keys = [];
        $values = [];

        foreach ($value->getContents() as $key => $item) {
            $keys[] = $key->accept($this);
            $values[] = $item->accept($this);
        }

        return [Type::T_MAP, $keys, $values];
    }

    public function visitNull()
    {
        return Compiler::$null;
    }

    public function visitNumber(SassNumber $value)
    {
        return new Number($value->getValue(), $value->getNumeratorUnits(), $value->getDenominatorUnits());
    }

    public function visitString(SassString $value)
    {
        return [Type::T_STRING, $value->hasQuotes() ? '"' : '', [$value->getText()]];
    }
}

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

namespace Flames\Transpiler\Scss\Visitor;

use Flames\Transpiler\Scss\Value\SassBoolean;
use Flames\Transpiler\Scss\Value\SassCalculation;
use Flames\Transpiler\Scss\Value\SassColor;
use Flames\Transpiler\Scss\Value\SassFunction;
use Flames\Transpiler\Scss\Value\SassList;
use Flames\Transpiler\Scss\Value\SassMap;
use Flames\Transpiler\Scss\Value\SassMixin;
use Flames\Transpiler\Scss\Value\SassNumber;
use Flames\Transpiler\Scss\Value\SassString;

/**
 * An interface for visitors that traverse SassScript $values.
 *
 * @internal
 *
 * @template T
 */
interface ValueVisitor
{
    /**
     * @return T
     */
    public function visitBoolean(SassBoolean $value);

    /**
     * @return T
     */
    public function visitCalculation(SassCalculation $value);

    /**
     * @return T
     */
    public function visitColor(SassColor $value);

    /**
     * @return T
     */
    public function visitFunction(SassFunction $value);

    /**
     * @return T
     */
    public function visitMixin(SassMixin $value);

    /**
     * @return T
     */
    public function visitList(SassList $value);

    /**
     * @return T
     */
    public function visitMap(SassMap $value);

    /**
     * @return T
     */
    public function visitNull();

    /**
     * @return T
     */
    public function visitNumber(SassNumber $value);

    /**
     * @return T
     */
    public function visitString(SassString $value);
}

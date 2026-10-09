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

namespace Flames\Transpiler\Scss\Parser;

use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * @phpstan-sealed MultiSourceFormatException
 * @internal
 */
class FormatException extends \Exception
{
    public function __construct(string $message, private readonly FileSpan $span, ?\Throwable $previous = null)
    {
        parent::__construct($message, 0, $previous);
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }
}

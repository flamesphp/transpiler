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

namespace Flames\Transpiler\Scss\Logger;

use Flames\Transpiler\Scss\Deprecation;
use Flames\Transpiler\Scss\StackTrace\Trace;
use Flames\Transpiler\Scss\Span\FileSpan;
use Flames\Transpiler\Scss\Span\SourceSpan;

/**
 * A logger that silently ignores all messages.
 */
final class QuietLogger implements LoggerInterface
{
    public function warn(string $message, ?Deprecation $deprecation = null, ?FileSpan $span = null, ?Trace $trace = null): void
    {
    }

    public function debug(string $message, SourceSpan $span): void
    {
    }
}

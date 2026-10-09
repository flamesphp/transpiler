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

namespace Flames\Transpiler\Scss\Exception;

use Flames\Transpiler\Scss\StackTrace\Trace;
use Flames\Transpiler\Scss\Util;
use Flames\Transpiler\Scss\Util\ErrorUtil;
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * @internal
 */
final class SimpleSassException extends \Exception implements SassException
{
    public function __construct(private readonly string $originalMessage, private readonly FileSpan $span, ?\Throwable $previous = null)
    {
        parent::__construct(ErrorUtil::formatErrorMessage($this->originalMessage, $this->span, $this->getSassTrace()), 0, $previous);
    }

    public function getOriginalMessage(): string
    {
        return $this->originalMessage;
    }

    public function getSpan(): FileSpan
    {
        return $this->span;
    }

    public function getSassTrace(): Trace
    {
        return new Trace([Util::frameForSpan($this->span, 'root stylesheet')]);
    }

    public function withAdditionalSpan(FileSpan $span, string $label, ?\Throwable $previous = null): MultiSpanSassException
    {
        return new MultiSpanSassException($this->originalMessage, $this->span, '', [$label => $span], $previous);
    }

    public function withTrace(Trace $trace, ?\Throwable $previous = null): SassRuntimeException
    {
        return new SimpleSassRuntimeException($this->originalMessage, $this->span, $trace, $previous);
    }
}

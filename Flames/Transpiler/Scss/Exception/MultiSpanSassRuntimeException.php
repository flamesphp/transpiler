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
use Flames\Transpiler\Scss\Span\FileSpan;

/**
 * @internal
 */
final class MultiSpanSassRuntimeException extends MultiSpanSassException implements SassRuntimeException
{
    /**
     * @param array<string, FileSpan> $secondarySpans
     */
    public function __construct(string $message, FileSpan $span, string $primaryLabel, array $secondarySpans, private readonly Trace $sassTrace, ?\Throwable $previous = null)
    {
        parent::__construct($message, $span, $primaryLabel, $secondarySpans, $previous);
    }

    public function getSassTrace(): Trace
    {
        return $this->sassTrace;
    }

    public function withAdditionalSpan(FileSpan $span, string $label, ?\Throwable $previous = null): MultiSpanSassRuntimeException
    {
        return new self($this->getOriginalMessage(), $this->getSpan(), $this->primaryLabel, $this->secondarySpans + [$label => $span], $this->sassTrace, $previous);
    }
}

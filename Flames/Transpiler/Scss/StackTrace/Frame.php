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

namespace Flames\Transpiler\Scss\StackTrace;

use Flames\Transpiler\Scss\Uri\Contracts\UriInterface;
use Flames\Transpiler\Scss\Util\Path;

/**
 * A single stack frame. Each frame points to a precise location in Sass code.
 */
final readonly class Frame
{
    public function __construct(
        /**
         * The URI of the file in which the code is located.
         */
        private UriInterface $url,
        /**
         * The line number on which the code location is located.
         *
         * This can be null, indicating that the line number is unknown or
         * unimportant.
         */
        private ?int $line,
        /**
         * The column number of the code location.
         *
         * This can be null, indicating that the column number is unknown or
         * unimportant.
         */
        private ?int $column,
        /**
         * The name of the member in which the code location occurs.
         */
        private ?string $member
    )
    {
    }

    /**
     * The URI of the file in which the code is located.
     */
    public function getUrl(): UriInterface
    {
        return $this->url;
    }

    /**
     * The line number on which the code location is located.
     *
     * This can be null, indicating that the line number is unknown or
     * unimportant.
     */
    public function getLine(): ?int
    {
        return $this->line;
    }

    /**
     * The column number of the code location.
     *
     * This can be null, indicating that the column number is unknown or
     * unimportant.
     */
    public function getColumn(): ?int
    {
        return $this->column;
    }

    /**
     * The name of the member in which the code location occurs.
     */
    public function getMember(): ?string
    {
        return $this->member;
    }

    /**
     * A human-friendly description of the code location.
     */
    public function getLocation(): string
    {
        $library = Path::prettyUri($this->url);

        if ($this->line === null) {
            return $library;
        }

        if ($this->column === null) {
            return $library . ' ' . $this->line;
        }

        return $library . ' ' . $this->line . ':' . $this->column;
    }
}

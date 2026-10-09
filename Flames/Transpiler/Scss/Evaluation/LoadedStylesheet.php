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

namespace Flames\Transpiler\Scss\Evaluation;

use Flames\Transpiler\Scss\Ast\Sass\Statement\Stylesheet;
use Flames\Transpiler\Scss\Importer\Importer;

/**
 * The result of loading a stylesheet via {@see EvaluateVisitor::loadStylesheet}.
 *
 * @internal
 */
final readonly class LoadedStylesheet
{
    public function __construct(
        /**
         * The stylesheet itself.
         */
        private Stylesheet $stylesheet,
        private Importer $importer,
        /**
         * Whether this load counts as a dependency.
         *
         * That is, whether this was (transitively) loaded through a load path or
         * importer rather than relative to the entrypoint.
         */
        private bool $dependency
    )
    {
    }

    public function getStylesheet(): Stylesheet
    {
        return $this->stylesheet;
    }

    public function getImporter(): Importer
    {
        return $this->importer;
    }

    public function isDependency(): bool
    {
        return $this->dependency;
    }
}

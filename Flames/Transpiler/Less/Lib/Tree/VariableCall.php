<?php
/**
 * @private
 * @see less-3.13.1.js#VariableCall
 * @todo missing allowRoot implementation https://github.com/less/less.js/commit/b67403d3
 */
class Less_Tree_VariableCall extends Less_Tree {

	/** @var string */
	public $type = "VariableCall";

	/**
     * @param string $variable
     * @param int $index
     * @param mixed[] $currentFileInfo
     */
    public function __construct(public $variable, private $index, private $currentFileInfo)
    {
    }

	public function accept( $visitor ) {
	}

	public function compile( $env ) {
		$detachedRuleset =  new Less_Tree_Variable( $this->variable, $this->index, $this->currentFileInfo  )
			->compile( $env );

		if ( !( $detachedRuleset instanceof Less_Tree_DetachedRuleset ) || !$detachedRuleset->ruleset ) {
			// order differs from upstream to simplify the code
			if ( is_array( $detachedRuleset ) ) {
				$rules = new Less_Tree_Ruleset( null, $detachedRuleset );
			} elseif (
				( $detachedRuleset instanceof Less_Tree_Ruleset
				|| $detachedRuleset instanceof Less_Tree_AtRule
				|| $detachedRuleset instanceof Less_Tree_Media
				|| $detachedRuleset instanceof Less_Tree_Mixin_Definition
				) && $detachedRuleset->rules
			) {
				// @todo - note looks like dead code, do we need it ?
				$rules = $detachedRuleset;
			} elseif ( $detachedRuleset instanceof Less_Tree && is_array( $detachedRuleset->value ) ) {
				$rules = new Less_Tree_Ruleset( null, $detachedRuleset->value );
			} else {
				throw new Less_Exception_Compiler( 'Could not evaluate variable call ' . $this->variable );
			}
			$detachedRuleset = new Less_Tree_DetachedRuleset( $rules );
		}
		if ( $detachedRuleset->ruleset ) {
			return $detachedRuleset->callEval( $env );
		}
		throw new Less_Exception_Compiler( 'Could not evaluate variable call ' . $this->variable );
	}
}

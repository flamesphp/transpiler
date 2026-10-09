<?php
/**
 * @private
 */
class Less_Tree_DetachedRuleset extends Less_Tree {

	/**
     * @param \Less_Tree_Ruleset $ruleset
     * @param mixed[]|null $frames
     */
    public function __construct(public $ruleset, public $frames = null)
    {
    }

	public function accept( $visitor ) {
		$this->ruleset = $visitor->visitObj( $this->ruleset );
	}

	public function compile( $env ) {
		if ( $this->frames ) {
			$frames = $this->frames;
		} else {
			$frames = $env->frames;
		}
		return new self( $this->ruleset, $frames );
	}

	public function callEval( $env ) {
		if ( $this->frames ) {
			return $this->ruleset->compile( $env->copyEvalEnv( array_merge( $this->frames, $env->frames ) ) );
		}
		return $this->ruleset->compile( $env );
	}
}

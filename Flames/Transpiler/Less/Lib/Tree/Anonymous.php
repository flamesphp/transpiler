<?php
/**
 * @private
 * @see less-2.5.3.js#Anonymous.prototype
 */
class Less_Tree_Anonymous extends Less_Tree implements Less_Tree_HasValueProperty {
	/** @var string|null */
	public $quote;

	/**
     * @param string $value
     * @param int|null $index
     * @param array|null $currentFileInfo
     * @param bool|null $mapLines
     * @param bool $rulesetLike
     * @param bool $isReferenced
     */
    public function __construct(public $value, public $index = null, public $currentFileInfo = null, public $mapLines = null, public $rulesetLike = false, public $isReferenced = false)
    {
    }

	public function compile( $env ) {
		return new self( $this->value, $this->index, $this->currentFileInfo, $this->mapLines, $this->rulesetLike, $this->isReferenced );
	}

	/**
	 * @param Less_Tree|mixed $x
	 * @return int|null
	 * @see less-3.13.1.js#Anonymous.prototype.compare
	 */
	public function compare( $x ) {
		return ( $x instanceof Less_Tree && $this->toCSS() === $x->toCSS() ) ? 0 : null;
	}

	public function isRulesetLike() {
		return $this->rulesetLike;
	}

	/**
	 * @see less-3.13.1.js#Anonymous.prototype.genCSS
	 */
	public function genCSS( $output ) {
		$this->nodeVisible = $this->value !== "" && $this->value !== 0;
		if ( $this->nodeVisible ) {
			$output->add( $this->value, $this->currentFileInfo, $this->index, $this->mapLines );
		}
	}

	public function markReferenced() {
		$this->isReferenced = true;
	}

	public function getIsReferenced() {
		return !isset( $this->currentFileInfo['reference'] ) || !$this->currentFileInfo['reference'] || $this->isReferenced;
	}
}

<?php
/**
 * @private
 * @see less-2.5.3.js#Comment.prototype
 */
class Less_Tree_Comment extends Less_Tree implements Less_Tree_HasValueProperty {
	/** @var bool */
	public $isLineComment;
	/** @var bool|null */
	public $isReferenced;

	/**
     * @param string $value
     * @param mixed[]|null $currentFileInfo
     */
    public function __construct( public $value, $isLineComment, $index = null, public $currentFileInfo = null ) {
		$this->isLineComment = (bool)$isLineComment;
	}

	public function genCSS( $output ) {
		// NOTE: Skip debugInfo handling (not implemented)

		$output->add( $this->value );
	}

	public function isSilent() {
		$isReference = ( $this->currentFileInfo && isset( $this->currentFileInfo['reference'] ) && ( !isset( $this->isReferenced ) || !$this->isReferenced ) );
		$isCompressed = Less_Parser::$options['compress'] && ( $this->value[2] ?? '' ) !== "!";
		return $this->isLineComment || $isReference || $isCompressed;
	}

	public function markReferenced() {
		$this->isReferenced = true;
	}

}

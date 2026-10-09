<?php
/**
 * @private
 */
class Less_Tree_UnicodeDescriptor extends Less_Tree implements Less_Tree_HasValueProperty {

	/**
     * @param string $value
     */
    public function __construct(public $value)
    {
    }

	/**
	 * @see Less_Tree::genCSS
	 */
	public function genCSS( $output ) {
		$output->add( $this->value );
	}
}

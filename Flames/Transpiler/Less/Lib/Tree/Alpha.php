<?php
/**
 * @private
 * @see less-2.5.3.js#Alpha.prototype
 */
class Less_Tree_Alpha extends Less_Tree implements Less_Tree_HasValueProperty {
	/**
     * @param string|Less_Tree $value This receives string or Less_Tree_Variable
     * from Less_Parser. In compile(), Less_Tree_Variable is replaced with a
     * different node (e.g. Less_Tree_Quoted).
     */
    public function __construct(public $value)
    {
    }

	public function accept( $visitor ) {
		if ( $this->value instanceof Less_Tree ) {
			$this->value = $visitor->visitObj( $this->value );
		}
	}

	public function compile( $env ) {
		if ( $this->value instanceof Less_Tree ) {
			return new self( $this->value->compile( $env ) );
		}

		return $this;
	}

	public function genCSS( $output ) {
		$output->add( "alpha(opacity=" );

		if ( $this->value instanceof Less_Tree ) {
			$this->value->genCSS( $output );
		} else {
			$output->add( $this->value );
		}

		$output->add( ')' );
	}
}

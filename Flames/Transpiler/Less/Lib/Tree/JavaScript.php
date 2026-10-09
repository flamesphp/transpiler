<?php
/**
 * @private
 * @see less-3.13.1.js#JavaScript.prototype
 */
class Less_Tree_JavaScript extends Less_Tree {

	/**
     * @param string $expression
     * @param bool $escaped
     * @param int $index
     */
    public function __construct(public $expression, public $escaped, public $index)
    {
    }

	public function compile( $env ) {
		return new Less_Tree_Anonymous( '/* Sorry, can not do JavaScript evaluation in PHP... :( */' );
	}

}

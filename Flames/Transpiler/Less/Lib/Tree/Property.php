<?php
/**
 * @private
 * @see less-3.13.1.js#tree.Property
 */
class Less_Tree_Property extends Less_Tree {

	/** @var bool */
	public $evaluating = false;

	/**
     * @param string $name
     * @param int|null $index
     * @param mixed[]|null $currentFileInfo
     */
    public function __construct(public $name, public $index = null, public $currentFileInfo = null)
    {
    }

	public function compile( $env ) {
		$name = $this->name;

		if ( $this->evaluating ) {
			throw new Less_Exception_Compiler(
				"Recursive property reference for " . $name,
				null,
				$this->index, $this->currentFileInfo
			);
		}

		$property = null;
		$this->evaluating = true;
		/** @var Less_Tree_Ruleset $frame */
		foreach ( $env->frames as $frame ) {
			$vArr = $frame->property( $name );
			if ( $vArr ) {
				$size = count( $vArr );
				for ( $i = 0; $i < $size; $i++ ) {
					$v = $vArr[$i];
					$vArr[$i] = new Less_Tree_Declaration(
						$v->name,
						$v->value,
						$v->important,
						$v->merge,
						$v->index,
						$v->currentFileInfo,
						$v->inline,
						$v->variable
					);
				}
				Less_Visitor_toCSS::_mergeRules( $vArr );
				$v = $vArr[ count( $vArr ) - 1 ];
				if ( isset( $v->important ) && $v->important ) {
					$importantScopeLength = count( $env->importantScope );
					$env->importantScope[ $importantScopeLength - 1 ]['important'] = $v->important;
				}
				$property = $v->value->compile( $env );
				break;
			}
		}

		if ( $property ) {
			$this->evaluating = false;
			return $property;
		} else {
			throw new Less_Exception_Compiler( "property '" . $name . "' is undefined in file " .
				$this->currentFileInfo["filename"], null, $this->index, $this->currentFileInfo );
		}
	}

}

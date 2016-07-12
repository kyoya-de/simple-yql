<?php
/**
 * This file is part of a marmalade GmbH project
 * It is not Open Source and may not be redistributed.
 * For contact information please visit http://www.marmalade.de
 *
 * @version    0.1
 * @author     Stefan Krenz <krenz@marmalade.de>
 * @link       http://www.marmalade.de
 */

namespace Kyoya\YQL\Expression\Where;

use Kyoya\YQL\Expression\CompilableInterface;
use Kyoya\YQL\Expression\MissingValuesException;
use Kyoya\YQL\InvalidArgumentException;

class In implements CompilableInterface {
    /**
     * @var string
     */
    private $field;

    /**
     * @var string[]
     */
    private $values;

    /**
     * In constructor.
     *
     * @param string   $field
     * @param string|CompilableInterface $values
     */
    public function __construct($field, $values) {
        if ((!$values instanceof CompilableInterface) && !is_array($values)) {
            throw new InvalidArgumentException(
                "The argument 'values' must be either an array or an instance of 'CompilableInterface'!"
            );
        }
        $this->field  = (string) $field;
        $this->values = $values;
    }

    public function compile() {
        if ($this->values instanceof CompilableInterface) {
            $values = $this->values->compile();
        } else {
            if (0 == count($this->values)) {
                throw new MissingValuesException("You must provide at least one value for the 'IN' expression!");
            }

            $values = implode(
                ",",
                array_map(
                    function ($element) {
                        return "\"{$element}\"";
                    },
                    $this->values
                )
            );
        }

        return "{$this->field} IN ({$values})";
    }

}

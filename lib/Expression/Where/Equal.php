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

class Equal implements CompilableInterface {
    /**
     * @var string
     */
    private $field;

    /**
     * @var float|int|string
     */
    private $value;

    /**
     * Equal constructor.
     *
     * @param string $field
     * @param string|int|float $value
     */
    public function __construct($field, $value) {
        $this->field = (string) $field;
        $this->value = $value;
    }

    public function compile() {
        $compiledValue = $this->value;
        if (!is_numeric($compiledValue)) {
            $compiledValue = "\"{$compiledValue}\"";
        }

        return "{$this->field} = {$compiledValue}";
    }

}

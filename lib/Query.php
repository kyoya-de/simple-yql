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

namespace Kyoya\YQL;

use Kyoya\YQL\Expression;

class Query implements QueryInterface {
    /**
     * @var Expression\CompilableInterface
     */
    private $query;

    public function __construct(Expression\CompilableInterface $query = null) {
        $this->query = $query;
    }

    /**
     * @param string|string[] $fields
     * @param null   $from
     *
     * @return Expression\Select
     */
    public function select($fields = '*', $from = null) {
        $this->query = new Expression\Select((array) $fields, $from);

        return $this->query;
    }

    public function getQuery() {
        return $this->query->compile();
    }
}

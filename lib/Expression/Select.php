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

namespace Kyoya\YQL\Expression;

use Kyoya\YQL\InvalidArgumentException;

class Select implements CompilableInterface {
    const WHERE_AND = 'AND';
    const WHERE_OR = 'OR';

    /**
     * @var string[]
     */
    private $fields;

    /**
     * @var string
     */
    private $from;

    /**
     * @var \SplObjectStorage
     */
    private $where;

    /**
     * Select constructor.
     *
     * @param string[]    $fields
     * @param null|string $from
     */
    public function __construct(array $fields = ['*'], $from = null) {
        $this->fields = $fields;
        if (null !== $from) {
            $this->from = (string) $from;
        }

        $this->where = new \SplObjectStorage();
    }

    public function from($table) {
        $this->from = (string) $table;

        return $this;
    }

    public function where(CompilableInterface $expr, $operator = 'AND') {
        if (!in_array($operator, ['AND', 'OR'])) {
            throw new InvalidArgumentException(
                sprintf("The operator must be one of: AND, OR, but got '%s'", $operator)
            );
        }
        $this->where->attach($expr, $operator);

        return $this;
    }

    public function compile() {
        $from   = $this->from;
        $fields = implode(",", $this->fields);
        return "SELECT {$fields} FROM {$from}" . $this->compileWhere();
    }

    private function compileWhere() {
        if (null === $this->where) {
            return '';
        }

        $where = ' WHERE';
        foreach ($this->where as $index => $expression) {
            if (0 < $index) {
                $where .= ' ' . $this->where[$expression];
            }

            $where .= ' ';
            $compiledExpr = $expression->compile();

            if ($expression instanceof Select) {
                $where .= "({$compiledExpr})";

                continue;
            }

            $where .= $compiledExpr;
        }

        return $where;
    }
}

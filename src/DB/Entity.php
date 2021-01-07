<?php

namespace Code\DB;

use \PDO;

abstract class  Entity
{
    /**
     * @var PDO
     */
    private $conn;
    protected $tables;

    public function __construct(\PDO $conn)
    {

        $this->conn = $conn;
    }

    public function findAll($fildes = '*')
    {
        $sql = 'SELECT ' . $fildes . ' FROM products' . $this->tables;

        $get = $this->conn->query($sql);
        return $get->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(int $id)
    {
        $sql = 'SELECT * FROM products WHERE id = :id';

        $get = $this->conn->prepare($sql);
        $get->bindValue(':id', $id, \PDO::PARAM_INT);

        $get->execute();

        return $get->fetch(PDO::FETCH_ASSOC);

    }

    public function where(array $conditions, $operator = ' AND ', $fields = '*')
    {
        $sql = 'SELECT ' . $fields . ' FROM ' . $this->tables . ' WHERE ';

        $binds = array_keys($conditions);

        $where = null;
        foreach ($binds as $v) {
            if (is_null($where)) {
                $where .= $v . ' = :' . $v;
            } else {
                $where .= $operator . $v . ' = :' . $v;
            }
        }

        $sql .= $where;
        $get = $this->conn->prepare($sql);

        foreach ($conditions as $k => $v) {
            gettype($v) == 'int' ? $get->bindValue(':' . $k, $v, \PDO::PARAM_INT)
                            : $get->bindValue(':' . $k, $v, \PDO::PARAM_STR);
        }

        $get->execute();

        return $get->fetchAll(\PDO::FETCH_ASSOC);
    }
}
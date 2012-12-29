<?php

class DatabaseModel
{

    protected $tableName;

    protected $fields;

    private function attributes ()
    {
        $string = array();
        foreach ($this->fields as $field) {
            if (is_int($this->$field)) {
                $string[] = "$field = " . $this->$field . "";
            } else {
                $string[] = "$field = '" . $this->$field . "'";
            }
        }
        return join(', ', $string);
    }

    final public static function read ($sql, $resultType = PDO::FETCH_ASSOC, $className = false)
    {
        global $dbh;
        $results = $dbh->query($sql);
        if ($results) {
            if ($resultType == PDO::FETCH_CLASS && $className) {
                $resultSet = $results->fetchAll(PDO::FETCH_CLASS, $className);
            } else {
                $resultSet = $results->fetchAll($resultType);
            }
            if (count($resultSet) == 1) {
                return array_shift($resultSet);
            } else {
                return $resultSet;
            }
        } else {
            return false;
        }
    }
    
    public static function getAll($table)
    {
        return self::read('SELECT * FROM ' . $table, PDO::FETCH_CLASS, __CLASS__);
    }

    final public function save ()
    {
        return (null === $this->id) ? $this->add() : $this->update();
    }

    final protected function add ()
    {
        global $dbh;
        $sql = 'INSERT INTO ' . $this->tableName . ' SET ' . $this->attributes();
        $numberOfAffectedRows = $dbh->exec($sql);
        if ($numberOfAffectedRows > 0) {
            $this->id = $dbh->lastInsertId();
        }
        return ($numberOfAffectedRows > 0) ? $numberOfAffectedRows : false;
    }

    final protected function update ()
    {
        global $dbh;
        $sql = 'UPDATE ' . $this->tableName . ' SET ' . $this->attributes() .
                 ' WHERE id = ' . $this->id;
        $numberOfAffectedRows = $dbh->exec($sql);
        return ($numberOfAffectedRows > 0) ? $numberOfAffectedRows : false;
    }

    final public function delete ()
    {
        global $dbh;
        $sql = 'DELETE FROM ' . $this->tableName . ' WHERE id = ' . $this->id;
        $numberOfAffectedRows = $dbh->exec($sql);
        return ($numberOfAffectedRows > 0) ? $numberOfAffectedRows : false;
    }
}
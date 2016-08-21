<?php

namespace CakeEloquent\ORM;


use Cake\ORM\Entity as BaseEntity;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;


class Entity extends BaseEntity
{

    public $_table = null;


    public function __construct(array $properties = [], array $options = [])
    {
        parent::__construct($properties, $options);
        return $this;
    }

    public function save()
    {
        $table = $this->_getTable();
        return (new $table)->instance()->save($this);
    }

    public function delete()
    {
        $table = $this->_getTable();
        return (new $table)->instance()->delete($this);
    }

    private function _getTable()
    {
        if ($this->_table === null) {
            $this->_table = str_replace('Model\Entity', 'Model\Table', Inflector::pluralize(static::class)) . 'Table';
        }
        return $this->_table;
    }

    public function source($alias = null)
    {
        $table = $this->_getTable();
        return (new $table)->instance();
    }

}

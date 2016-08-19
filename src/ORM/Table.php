<?php
namespace CakeORM\ORM;


use Cake\Datasource\ConnectionManager;
use Cake\ORM\Table as BaseTable;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;


class Table
{

    protected $_instance;

    protected $_entity;

    public function __construct(array $config = [])
    {
        $config += [
            'primaryKey' => 'id',
            'displayField' => 'name',
            'connection' => ConnectionManager::get('default'),
            'alias' => $this->_getAlias(),
            'entityClass' => $this->_getEntityClass()
        ];
        $this->_instance = new BaseTable($config);
        $this->_instance->primaryKey($config['primaryKey']);
        $this->_instance->displayField($config['displayField']);
    }

    /**
     * Create new
     *
     * @param array $data
     * @return mixed
     */
    public static function create($data = [])
    {
        $in = new static;
        $entity = $in->instance()->newEntity($data);
        return $in->instance()->save($entity);
    }

    public static function all($options = [])
    {
        $in = new static;
        return $in->instance()->find('all', $options);
    }

    public static function findList($options = [])
    {
        $in = new static;
        return $in->instance()->find('list', $options);
    }

    public static function first($options = [])
    {
        return static::all($options)->first();
    }

    public static function get($primaryKey, $options = [])
    {
        $in = new static;
        return $in->instance()->get($primaryKey, $options);
    }

    public function instance()
    {
        return $this->_instance;
    }

    private function _getAlias()
    {
        $alias = str_replace('Table', '', $this->_getClassName());
        if ($plugin = $this->_getPlugin()) {
            return $plugin . '.' . $alias;
        }
        return $alias;
    }

    private function _getEntityClass()
    {
        $entityClass = str_replace(
            ['Model\Table', $this->_getClassName()],
            ['Model\Entity', Inflector::singularize($this->_getAlias())],
            static::class
        );

        if (class_exists($entityClass)) {
            return $entityClass;
        }
        return '\App\Model\Entity';
    }

    private function _getPlugin()
    {
        $class = explode('\\', static::class);
        return ($class[0] == 'App') ? null : $class[0];
    }

    private function _getClassName()
    {
        $class = explode('\\', static::class);
        return array_pop($class);
    }

}
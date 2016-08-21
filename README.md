# CAKEPHP ELOQUENT

Use Laravels Eloquent ORM in CakePHP 3.

These should make the code more readable and easier to use.

I just started the project, so there are only a few functions. :-)

**Please don't use it in production!**

It should work, but there is no guarantee.

## Dependencies

* CakePHP3
* PHP5.5


## Examples

**Table**

Before

    $users = TableRegistry::get('UsersTable')->find();
    $user = TableRegistry::get('UsersTable')->get($id);
    
After

    $users = UsersTable::all();
    $user = UsersTable::get($id);
    

**Entity**

Before

    $user = TableRegistry::get('Users')->newEntity();
    $user = TableRegistry::patchEntity($user, $this->request->data);
    $user = TableRegistry::get('Users')->save($user);

After

    $user = new User();
    $user->set($this->request->data);
    $user->save();
    
    
    
## Usage

**Table**

Use CakeORM\ORM\Table instead of Cake\ORM\Table

    use CakeORM\ORM\Table;
    
    class UsersTable extends Table
    {
    
        // - use constructor to add your table config
        public function __construct()
        {
            parent::__construct([
                'table' => 'users',
                'displayField' => 'name'
            ]);

            /**
             * $this->instance() returns the Cake\ORM\Table object so
             * you can access all functions of the original CakePHP ORM class
            **/
            $this->instance()->addBehavior('Timestamp');
        }
    
    }
    

**Entity**

Use CakeORM\ORM\Entity instead of Cake\ORM\Entity

    use CakeORM\ORM\Entity;
    
    class User extends Entity
    {
    
        /**
          * Table class is only needed if you don't want to use automagic or you use
          * another table class name
         **/
        public $_table = 'App\Model\Table\UsersTable';
    
    }
    
    
## Known issues

* Use CakeORM\ORM\Entity as default entity class
* Not tested with plugins


## Functions

### Table

**Table::create($data)**

Create an entity with $data, save it and return the instance.
Returns CakeORM\ORM\Entity.

**Table::all($options = []**

Get all entities.
Returns Cake\ORM\Query.

**Table::first($options = [])**

Get first entity.
Returns CakeORM\ORM\Entity.

**Table::get($primaryKey, $options = [])**

Get first entity with given primary key.
Returns CakeORM\ORM\Entity.

**Table::instance()->PLACEHOLDER**

The function instance returns the Cake\ORM\Table, so you can use all the other functions given by Cake.


### Entity

**Entity->save()**

Save the entity and return the instance

**Entity->delete()**

Delete the entity from the database

CakeORM\ORM\Entity extends Cake\ORM\Entity, so you can use all the other functions given by Cake.

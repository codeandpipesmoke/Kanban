<?php
declare(strict_types=1);

namespace App\Model\Table;


use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * Positions Model
 *
 * @property \App\Model\Table\TasksTable&\Cake\ORM\Association\HasMany $Tasks
 *
 * @method \App\Model\Entity\Position newEmptyEntity()
 * @method \App\Model\Entity\Position newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Position> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Position get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Position findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Position patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Position> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Position|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Position saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Position>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Position>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Position>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Position> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Position>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Position>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Position>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Position> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PositionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('positions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Tasks', [
            'foreignKey' => 'position_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->boolean('visible')
            ->notEmptyString('visible');

        $validator
            ->integer('pos')
            ->notEmptyString('pos');

        $validator
            ->nonNegativeInteger('task_count')
            ->notEmptyString('task_count');

        return $validator;
    }
}

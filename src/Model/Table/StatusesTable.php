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
 * Statuses Model
 *
 * @property \App\Model\Table\ColsTable&\Cake\ORM\Association\HasMany $Cols
 * @property \App\Model\Table\TasksTable&\Cake\ORM\Association\HasMany $Tasks
 *
 * @method \App\Model\Entity\Status newEmptyEntity()
 * @method \App\Model\Entity\Status newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Status> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Status get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Status findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Status patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Status> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Status|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Status saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Status>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Status>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Status>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Status> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Status>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Status>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Status>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Status> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StatusesTable extends Table
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

        $this->setTable('statuses');
        $this->setDisplayField('status');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Cols', [
            'foreignKey' => 'status_id',
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'status_id',
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
            ->scalar('status')
            ->maxLength('status', 50)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->boolean('visible')
            ->notEmptyString('visible');

        $validator
            ->integer('pos')
            ->notEmptyString('pos');

        $validator
            ->nonNegativeInteger('task_count')
            ->notEmptyString('task_count');

        $validator
            ->nonNegativeInteger('col_count')
            ->allowEmptyString('col_count');

        return $validator;
    }
}

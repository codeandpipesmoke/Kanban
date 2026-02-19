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
 * Cols Model
 *
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\BelongsTo $Projects
 * @property \App\Model\Table\TasksTable&\Cake\ORM\Association\HasMany $Tasks
 *
 * @method \App\Model\Entity\Col newEmptyEntity()
 * @method \App\Model\Entity\Col newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Col> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Col get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Col findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Col patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Col> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Col|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Col saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Col>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Col>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Col>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Col> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Col>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Col>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Col>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Col> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 * @mixin \Cake\ORM\Behavior\CounterCacheBehavior
 */
class ColsTable extends Table
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

        $this->setTable('cols');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Projects' => ['col_count'],
        ]);

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'col_id',
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
            ->integer('project_id')
            ->notEmptyString('project_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

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
            ->allowEmptyString('task_count');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['project_id'], 'Projects'), ['errorField' => '0']);

        return $rules;
    }
}

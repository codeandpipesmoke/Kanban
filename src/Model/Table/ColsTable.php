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
 * @property \App\Model\Table\ViewsTable&\Cake\ORM\Association\BelongsTo $Views
 * @property \App\Model\Table\TypesTable&\Cake\ORM\Association\BelongsTo $Types
 * @property \App\Model\Table\StatusesTable&\Cake\ORM\Association\BelongsTo $Statuses
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
        $this->setDisplayField('header');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('CounterCache', [
            'Projects' => ['col_count'],
            'Views' => ['col_count'],
            'Statuses' => ['col_count'],
        ]);

        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Views', [
            'foreignKey' => 'view_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Types', [
            'foreignKey' => 'type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Statuses', [
            'foreignKey' => 'status_id',
            'joinType' => 'INNER',
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
            ->nonNegativeInteger('view_id')
            ->notEmptyString('view_id');

        $validator
            ->nonNegativeInteger('type_id')
            ->notEmptyString('type_id');

        $validator
            ->nonNegativeInteger('status_id')
            ->notEmptyString('status_id');

        $validator
            ->scalar('header')
            ->maxLength('header', 250)
            ->requirePresence('header', 'create')
            ->notEmptyString('header');

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
        $rules->add($rules->existsIn(['view_id'], 'Views'), ['errorField' => '1']);
        $rules->add($rules->existsIn(['type_id'], 'Types'), ['errorField' => '2']);
        $rules->add($rules->existsIn(['status_id'], 'Statuses'), ['errorField' => '3']);

        return $rules;
    }
}

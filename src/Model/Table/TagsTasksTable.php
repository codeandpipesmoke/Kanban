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
 * TagsTasks Model
 *
 * @property \App\Model\Table\TagsTable&\Cake\ORM\Association\BelongsTo $Tags
 * @property \App\Model\Table\TasksTable&\Cake\ORM\Association\BelongsTo $Tasks
 *
 * @method \App\Model\Entity\TagsTask newEmptyEntity()
 * @method \App\Model\Entity\TagsTask newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TagsTask> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TagsTask get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TagsTask findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TagsTask patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TagsTask> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TagsTask|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TagsTask saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TagsTask>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TagsTask>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TagsTask>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TagsTask> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TagsTask>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TagsTask>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TagsTask>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TagsTask> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TagsTasksTable extends Table
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

        $this->setTable('tags_tasks');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Tags', [
            'foreignKey' => 'tag_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'joinType' => 'INNER',
        ]);

		// Itt állítjuk be a számlálót
		$this->addBehavior('CounterCache', [
			'Tags' => ['task_count'],	// Ez a mező frissül a 'tags' táblában
			'Tasks' => ['tag_count'],	// Ez a mező frissül a 'tasks' táblában
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
            ->nonNegativeInteger('tag_id')
            ->notEmptyString('tag_id');

        $validator
            ->nonNegativeInteger('task_id')
            ->notEmptyString('task_id');

        $validator
            ->boolean('visible')
            ->requirePresence('visible', 'create')
            ->notEmptyString('visible');

        $validator
            ->integer('pos')
            ->requirePresence('pos', 'create')
            ->notEmptyString('pos');

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
        $rules->add($rules->existsIn(['tag_id'], 'Tags'), ['errorField' => '0']);
        $rules->add($rules->existsIn(['task_id'], 'Tasks'), ['errorField' => '1']);

        return $rules;
    }
}

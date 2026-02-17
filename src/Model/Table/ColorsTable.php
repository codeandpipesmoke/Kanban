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
 * Colors Model
 *
 * @method \App\Model\Entity\Color newEmptyEntity()
 * @method \App\Model\Entity\Color newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Color> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Color get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Color findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Color patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Color> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Color|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Color saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Color>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Color>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Color>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Color> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Color>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Color>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Color>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Color> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ColorsTable extends Table
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

        $this->setTable('colors');
        $this->setDisplayField('value');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('value')
            ->maxLength('value', 50)
            ->requirePresence('value', 'create')
            ->notEmptyString('value');

        $validator
            ->integer('pos')
            ->notEmptyString('pos');

        $validator
            ->boolean('visible')
            ->notEmptyString('visible');

        $validator
            ->nonNegativeInteger('task_count')
            ->allowEmptyString('task_count');

        return $validator;
    }
}

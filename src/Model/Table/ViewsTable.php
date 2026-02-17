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
 * Views Model
 *
 * @property \App\Model\Table\ColsTable&\Cake\ORM\Association\HasMany $Cols
 *
 * @method \App\Model\Entity\View newEmptyEntity()
 * @method \App\Model\Entity\View newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\View> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\View get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\View findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\View patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\View> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\View|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\View saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\View>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\View>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\View>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\View> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\View>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\View>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\View>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\View> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ViewsTable extends Table
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

        $this->setTable('views');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Cols', [
            'foreignKey' => 'view_id',
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
            ->nonNegativeInteger('col_count')
            ->allowEmptyString('col_count');

        return $validator;
    }
}

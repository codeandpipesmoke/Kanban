<?php
declare(strict_types=1);

namespace App\Model\Entity;


use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * Position Entity
 *
 * @property string $id
 * @property string $name
 * @property bool $visible
 * @property int $pos
 * @property int $task_count
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Task[] $tasks
 */
class Position extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'id' => true,
        'name' => true,
        'visible' => true,
        'pos' => true,
        'task_count' => true,
        'created' => true,
        'modified' => true,
        'tasks' => true,
    ];
}

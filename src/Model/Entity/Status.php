<?php
declare(strict_types=1);

namespace App\Model\Entity;


use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * Status Entity
 *
 * @property int $id
 * @property string $status
 * @property bool $visible
 * @property int $pos
 * @property int $task_count
 * @property int|null $col_count
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Col[] $cols
 * @property \App\Model\Entity\Task[] $tasks
 */
class Status extends Entity
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
        'status' => true,
        'visible' => true,
        'pos' => true,
        'task_count' => true,
        'col_count' => true,
        'created' => true,
        'modified' => true,
        'cols' => true,
        'tasks' => true,
    ];
}

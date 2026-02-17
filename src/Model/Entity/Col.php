<?php
declare(strict_types=1);

namespace App\Model\Entity;


use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * Col Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $view_id
 * @property int $type_id
 * @property int $status_id
 * @property string $header
 * @property bool $visible
 * @property int $pos
 * @property int|null $task_count
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\View $view
 * @property \App\Model\Entity\Type $type
 * @property \App\Model\Entity\Status $status
 */
class Col extends Entity
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
        'project_id' => true,
        'view_id' => true,
        'type_id' => true,
        'status_id' => true,
        'header' => true,
        'visible' => true,
        'pos' => true,
        'task_count' => true,
        'created' => true,
        'modified' => true,
        'project' => true,
        'view' => true,
        'type' => true,
        'status' => true,
    ];
}

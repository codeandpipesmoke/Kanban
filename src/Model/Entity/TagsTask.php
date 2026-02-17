<?php
declare(strict_types=1);

namespace App\Model\Entity;


use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * TagsTask Entity
 *
 * @property int $id
 * @property int $tag_id
 * @property int $task_id
 * @property bool $visible
 * @property int $pos
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Tag $tag
 * @property \App\Model\Entity\Task $task
 */
class TagsTask extends Entity
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
        'tag_id' => true,
        'task_id' => true,
        'visible' => true,
        'pos' => true,
        'created' => true,
        'modified' => true,
        'tag' => true,
        'task' => true,
    ];
}

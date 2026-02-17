<?php
declare(strict_types=1);

namespace App\Model\Entity;


use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * Task Entity
 *
 * @property int $id
 * @property int $status_id
 * @property string $text
 * @property string|null $description
 * @property bool $priority
 * @property bool $deleted
 * @property bool $visible
 * @property int $pos
 * @property int|null $tag_count
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Status $status
 * @property \App\Model\Entity\Tag[] $tags
 */
class Task extends Entity
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
        'status_id' => true,
        'text' => true,
        'description' => true,
        'priority' => true,
        'deleted' => true,
        'visible' => true,
        'pos' => true,
        'tag_count' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'tags' => true,
    ];
}

<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Task> $tasks
 */
use Cake\Core\Configure;

$layoutTasksLastId = -1;
if($session->check('Layout.Tasks.LastId')){
	$layoutTasksLastId = $session->read('Layout.Tasks.LastId');
}

$global_config = (array) Configure::read('Theme.' . $prefix . '.config.template.index');
$local_config = [
	'show_id' 			=> false,
	'show_pos' 			=> false,
	'show_counters'		=> false,
	'action_db_click'	=> 'edit',	// none, edit or view
	// ... more config params in: \Jeffadmin\config\jeffadmin.php
];
$config = array_merge($global_config, $local_config);
?>
				<div class="tasks index row">
						
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<div class="card">
							<div class="card-header">
							
								<div class="float-start">
									<h3><i id="card-icon" class="fa fa-table fa-spin"></i> <?= __('Table') ?>: <?= __('Tasks') ?></h3>
									<div><?php
										if($config['action_db_click'] == 'edit'){
											echo __('Double clik to edit row');
										}
										if($config['action_db_click'] == 'view'){
											echo __('Double clik to view row');
										}
									?></div>
								</div>
								
								<div class="float-end">
									<!-- Paginator page links -->
									<?= $this->element('Jeffadmin.paginator') ?>
									<!-- /.Pginator page links -->
								</div>
								
							</div>

<?php ####################################################################################################################################################### ?>
<?php ###################### CARD BODY ###################################################################################################################### ?>
<?php ####################################################################################################################################################### ?>

							<div class="card-body p-0 p-1">
								
								<table class="table table-responsive-xl table-hover table-striped mb-0 text-nowrap" style="">
									<thead class="thead-info">
										<tr>
											<th class="row-id-anchor"></th>
<?php if($config['show_id']){ ?>
											<th class="number id"><?= $this->Paginator->sort('id') ?></th>
<?php } ?>
											<?php /* <th class="string col-id"><?= $this->Paginator->sort('Cols.pos', __('Pos'), ['sort' => 'Cols.pos', 'direction' => 'asc', 'lock' => false]) */ ?></th><!-- H.0. -->
											<th class="string color-id" style="width: 10px;">
												<?= $this->Paginator->sort('Colors.pos', __('C'), ['lock' => false]) ?>											
											</th><!-- H.0. -->
											<th class="string col-id">
												<?= $this->Paginator->sort('Cols.pos', __('Pos'), ['lock' => false]) ?><br>
												
											</th><!-- H.0. -->
											<th class="string name"><?= $this->Paginator->sort('Tasks.name', __('Title')) ?></th><!-- H.1. -->
											<th class="boolean priority"><?= $this->Paginator->sort('Tasks.priority', __('Priority')) ?></th><!-- H.1. -->
											<th class="boolean deleted"><?= $this->Paginator->sort('Tasks.deleted', __('Deleted')) ?></th><!-- H.1. -->
<?php if($config['show_pos']){ ?>
											<th class="number pos"><?= $this->Paginator->sort('pos') ?></th>
<?php } ?>
<?php if($config['show_visible']){ ?>
											<th class="boolean visible"><?= $this->Paginator->sort('visible') ?></th>
<?php } ?>
<?php if($config['show_counters']){ ?>
											<th class="number counter tag_count"><?= $this->Paginator->sort('tag_count') ?></th><?php } ?>
<?php if($config['show_created'] || $config['show_modified']){ ?>

											<th class="datetime created modified">
												<?php 
													if($config['show_created']){ 
														echo $this->Paginator->sort('created');
													}
													if($config['show_created'] && $config['show_modified']){
														echo "&nbsp;/&nbsp;";
													}
													if($config['show_modified']){
														echo $this->Paginator->sort('modified');
													} ?>

											</th>
<?php } ?>
<?php if($config['show_button_view'] || $config['show_button_edit'] || $config['show_button_delete'] ){ ?>
											<th class="actions"><?= __('Actions') ?></th>
<?php } ?>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($tasks as $task): ?>
<?php
	//dd($task->tag_count);
	//$classLastVisited = ' class="last-visited"';	// later...
	//$classLastVisited = '';
?>

										<tr row-id="<?= $task->id ?>"<?php if($task->id == $layoutTasksLastId){ echo 'class="table-tr-last-id"'; } ?> prefix="<?= $prefix ?>" controller="<?= $controller ?>" action="<?= $action ?>" aria-expanded="true">
											<td class="row-id-anchor" value="<?= $task->id ?>"><a name="<?= $task->id ?>" class="anchor"></a></td>
<?php if($config['show_id']){ ?>
											<td class="number id" value="<?= $task->id ?>"><?= h($task->id) ?><a name="<?= $task->id ?>"></a></td>
<?php } ?>
											<td class="string link color-id" style="background-color: <?= $task->color->color ?>" value="<?= $task->col_id ?>">
												<?php /* $task->hasValue('color') ? $this->Html->link('<div style="background-color: ' . $task->color->color . '; width: 24px; height: 24px; margin-right: 5px; float: left;"></div>' . $task->color->name, ['controller' => 'Colors', 'action' => 'view', $task->color->id], ['escape' => false]) : '' ?><span class="external-link-icon"><i class="fa fa-external-link" aria-hidden="true"></i></span> */ ?>
											</td>
											<td class="string link col-id" value="<?= $task->col_id ?>">
												<?= $task->hasValue('col') ? $this->Html->link($task->col->name, ['controller' => 'Cols', 'action' => 'view', $task->col->id]) : '' ?><span class="external-link-icon"><i class="fa fa-external-link" aria-hidden="true"></i></span><br>
											</td>
											<td class="string name" value="<?= $task->name ?>">
												<b><?= h($task->name) ?></b>
<?php if($task->tag_count > 0){
												echo "<br>\n";
	$tags = '';
	foreach($task->tags as $tag){
		$tags .= $tag->name . ', ';									
	}
	$tags = substr($tags, 0, -2);
												echo "<span style='color: green;'>[" . $tags . "]</span>";
} ?>

<?php if(count($task->comments) > 0){
												echo "<br>\n";
} ?>

<?php foreach($task->comments as $comment){ ?>
												• <?= $comment->text ?>
												
												• <?= $this->Html->link('módosít', 
													['controller' => 'Comments', 'action' => 'edit', $comment->id],
													['escape' => false, 'role' => 'button', 
														//'class' => 'btn btn-primary btn-sm',
														//'style' => 'padding-y: 0px;',
														'data-toggle' => 'tooltip', 
														'data-placement' => 'top', 
														'title' => __('Edit this item'),
														'data-original-title' => __('Edit this item')
													]) ?> •
												
												<?= $this->Form->postLink('', 
													['controller' => 'Comments', 'action' => 'delete', $comment->id],
													['class'=>'hide-postlink index-delete-button-class']
													//['class'=>'hide-postlink']
													)
												?>
												<a href="javascript:;" class="postlink-delete text-danger fw-bold" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?= __("Delete this comment!") ?>" text="<?= h($comment->text) ?>" subText="<?= __("You will not be able to revert this!") ?>" confirmButtonText="<?= __("Yes, delete it!") ?>" cancelButtonText="<?= __("Cancel") ?>">töröl</a>


<?php /*												
												<?= $this->Form->postLink('', ['action' => 'delete', $task->id], ['class'=>'hide-postlink index-delete-button-class']) ?>
												<a href="javascript:;" class="btn btn-sm btn-danger postlink-delete" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?= __("Delete this record!") ?>" text="<?= h($task->name) ?>" subText="<?= __("You will not be able to revert this!") ?>" confirmButtonText="<?= __("Yes, delete it!") ?>" cancelButtonText="<?= __("Cancel") ?>"><i class="fa fa-minus"></i></a>
*/ ?>
												
												


												• <span class="small fst-italic text-muted"><?= h($comment->created) ?></span><br>
<?php } ?>
											</td>
											<td class="boolean priority" value="<?= $task->priority ?>"><?= h($task->priority) ?></td>
											<td class="boolean deleted" value="<?= $task->deleted ?>"><?= h($task->deleted) ?></td>
<?php if($config['show_pos']){ ?>
											<td class="number pos" value="<?= $task->pos ?>"><?= h($task->pos) ?></td>
<?php } ?>
<?php if($config['show_visible']){ ?>
											<td class="boolean visible" value="<?= $task->visible ?>"><?= h($task->visible) ?></td>
<?php } ?>
<?php if($config['show_counters']){ ?>
											<td class="number counter tag-count" value="<?= $task->tag_count ?>"><?= h($task->tag_count) ?></td><?php } ?>
<?php if($config['show_created'] || $config['show_modified']){ ?>
											<td class="datetime">
<?php if($config['show_created']){ ?>
												<span class="fw-bold"><?= h($task->created) ?></span>
<?php } ?>
<?php if($config['show_created'] && $config['show_modified']){ ?>
												<br>
<?php } ?>
<?php if($config['show_modified']){ ?>
												<span class="fw-normal"><?= h($task->modified) ?></span>
<?php } ?>
											</td>
<?php } ?>
<?php if($config['show_button_view'] || $config['show_button_edit'] || $config['show_button_delete'] ){ ?>

											<td class="actions">
<?php if($config['show_button_view']){ ?>
												<?= $this->Html->link('<i class="fa fa-eye"></i>', ['action' => 'view', $task->id], ['escape' => false, 'role' => 'button', 'class' => 'btn btn-warning btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => __('View this item'), 'data-original-title' => __('View this item')]) ?>
<?php } ?>

<?php if($config['show_button_edit']){ ?>
												<?= $this->Html->link('<i class="fa fa-edit"></i>', ['action' => 'edit', $task->id], ['escape' => false, 'role' => 'button', 'class' => 'btn btn-primary btn-sm', 'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => __('Edit this item'), 'data-original-title' => __('Edit this item')]) ?>
<?php } ?>

<?php if($config['show_button_delete']){ ?>
												<?= $this->Form->postLink('', ['action' => 'delete', $task->id], ['class'=>'hide-postlink index-delete-button-class']) ?>
												<a href="javascript:;" class="btn btn-sm btn-danger postlink-delete" data-bs-tooltip="tooltip" data-bs-placement="top" title="<?= __("Delete this record!") ?>" text="<?= h($task->name) ?>" subText="<?= __("You will not be able to revert this!") ?>" confirmButtonText="<?= __("Yes, delete it!") ?>" cancelButtonText="<?= __("Cancel") ?>"><i class="fa fa-minus"></i></a>

<?php } ?>

											</td>
<?php } ?>
										</tr>
										<?php endforeach; ?>

									</tbody>
								</table>

							</div>
							<div class="card-footer text-center">
								<div class="float-start">
									<?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
								</div>								
								<div class="float-end mb-1">							
									<?= $this->element('Jeffadmin.paginator') ?>
									
								</div>								
							</div>
						</div><!-- end card-->					
					</div>

				</div>			

	<?php
	if(isset($config['index_show_actions']) && $config['index_show_actions'] && isset($config['index_enable_delete']) && $config['index_enable_delete']){ 
		$this->Html->script(
			[
				"Jeffadmin./assets/plugins/sweetalert2/dist/sweetalert2.all.min",
				//"Jeffadmin./assets/plugins/jquery-copy-to-clipboard-master/jquery.copy-to-clipboard",
			],
			['block' => 'scriptBottom']
		);
	}	
	?>

<?php $this->Html->scriptStart(['block' => 'javaScriptBottom']); ?>

	$(document).ready( function(){
		$('tr').dblclick( function(){
			let id = $(this).attr("row-id")
			window.location.href = '<?= $this->Url->build(['controller' => $controller, 'action' => $config['action_db_click']]) ?>/' + id;
		})

		// Fixing CakePhp's paginator numbers
		$('.page-link').each( function(){
			if($(this).text() == '1'){
				$(this).attr('href', $(this).attr('href') + '?page=1');
			}
		});
		
	})
<?php $this->Html->scriptEnd(); ?>




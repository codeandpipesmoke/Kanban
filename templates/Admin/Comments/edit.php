<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Comment $comment
 * @var string[]|\Cake\Collection\CollectionInterface $tasks
 */
?>
<?php
use Cake\Core\Configure;
use Cake\I18n\FrozenTime;

$this->Form->setTemplates(Configure::read('Templates.form'));
$this->assign('title', __('Edit') . ' ' . __('Comment'));
?>
				<div id="form-row" class="comments row">
					<div class="col-xs-12 col-xl-10">
						<div class="card mb-3">
							<div class="card-header">

								<div class="float-start">
									<h3><i id="card-icon" class="fa fa-edit fa-spin"></i> <?= __('Edit') ?>: <?= __('Comment') ?></h3>
									<?= __('The data marked with <span class="fw-bold text-danger">*</span> must be provided!') ?>
								</div>

								<div class="float-end ms-5">
									<?= $this->Html->link('<span class="btn btn-outline-secondary mt-1 me-1"><i class="fa fa-times"></i></span>',
										["controller" => "Comments", "action" => "index", "_full" => true],
										["escape" => false, "role" => "button"]
									); ?>

								</div>

								<div class="form-tab float-end">
									<ul class="nav nav-tabs mt-1" id="myTab" role="tablist">
										<li class="nav-item" role="presentation">
											<button class="nav-link active" id="tabMain" data-bs-toggle="tab" data-bs-target="#tabPanelMain" type="button" role="tab" aria-controls="tabPanelMain" aria-selected="true"><?= __('Basic data') ?></button>
										</li>

<?php /*
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="tabText" data-bs-toggle="tab" data-bs-target="#tabPanelText" type="button" role="tab" aria-controls="tabPanelText" aria-selected="false"><?= __('Text') ?></button>
										</li>

										<li class="nav-item" role="presentation">
											<button class="nav-link" id="tabSecond" data-bs-toggle="tab" data-bs-target="#tabPanelSecond" type="button" role="tab" aria-controls="tabPanelSecond" aria-selected="false"><?= __('Memo') ?></button>
										</li>
										<li class="nav-item" role="presentation">
											<button class="nav-link" id="tabMore" data-bs-toggle="tab" data-bs-target="#tabPanelMore" type="button" role="tab" aria-controls="tabPanelMore" aria-selected="false"><?= __('More') ?></button>
										</li>
*/ ?>

									</ul>
								</div>

							</div>

							<?= $this->Form->create($comment, ['id' => 'main-form']) ?>
							
								<?php //= $this->Form->control('_csrfToken', ['name' => '_csrfToken', 'type' => 'hidden', 'value' => $this->request->getAttribute('csrfToken')] ) ?>

								<div class="card-body">
								
									<div class="tab-content" id="tabContent">
										
										<div class="tab-pane fade show active" id="tabPanelMain" role="tabpanel" aria-labelledby="tabMain" tabindex="0">

											<!-- 1. SELECT: task_id: integer  required -->
											<div class="mb-3 form-group row select required">
												<label class="col-form-label col-md-2 pt-1 text-start text-md-end required" for="task-id"><?= __('Task Id') ?>:</label>
												<div class="col-md-4">
													<?= $this->Form->control('task_id', ['options' => $tasks, 'placeholder' => __('Task Id'), 'class' => 'form-control select2', 'data-live-search' => false, 'data-container' => 'body', 'data-size' => '6', 'empty' => false]);	?>

												</div>
											</div>

<?php /*
											<!-- 3. INTEGER: user_id: integer  required -->
											<div class="mb-3 form-group row number required">
												<label class="col-form-label col-md-2 pt-1 text-start text-md-end required" for="user-id"><?= __('User Id') ?>:</label>
												<div class="col-xs-12 col-sm-12 col-md-5 col-lg-4 col-xl-4 col-xxl-4">
													<?= $this->Form->control('user_id', ['class' => 'form-control', 'placeholder' => __('User Id'), 'data-decimals' => '0', 'min' => '0', 'max' => '999999999999', 'step' => '1', 'empty' => false]); ?>

												</div>
											</div>
*/ ?>

											<div class="row mb-3">
												<div class="col-sm-12">
													<?= $this->Form->control('text', ['id' => 'text', 'label' => false, 'class' => 'summernote', 'empty' => false]); ?>

												</div>
											</div>

										</div><!-- /.tabPanelMain -->
										
<?php /*
										<!-- TabPanel: tabPanelText -->
										<!-- 10. TEXT: text: text  required -->
										<div class="tab-pane fade" id="tabPanelText" role="tabpanel" aria-labelledby="tabText" tabindex="0">
											<div class="row mb-3">
												<div class="col-sm-12">
													<?= $this->Form->control('text', ['id' => 'text', 'label' => false, 'class' => 'summernote', 'empty' => false]); ?>

												</div>
											</div>
										</div><!-- /.TabPanel: tabPanelText -->
*/ ?>

<?php /*											
										<div class="tab-pane fade" id="tabPanelMore" role="tabpanel" aria-labelledby="tabMore" tabindex="0">
											<h3>More content come here...</h3>

										</div><!-- /.N.TAB -->
*/ ?>

									</div><!-- /.TAB PANEL -->
										
								</div>

								<div class="card-footer text-center">
									<?= $this->Form->button('<span class="btn-label"><i class="fa fa-save"></i></span>' . __('Save'), ["escapeTitle" => false, "type" => "submit", "class" => "btn btn-primary me-4"]) ?>
									
									<?= $this->Html->link('<span class="btn-label"><i class="fa fa-arrow-up"></i></span>' . __("Cancel"),
										["controller" => "Comments", "action" => "index", "_full" => true],
										["escape" => false, "role" => "button", "class" => "btn btn-outline-secondary"]
									); ?>
									
								</div>

							<?= $this->Form->end() ?>

						</div><!-- end card-->
                    </div>


				</div>			


<?php
	$this->Html->css(
		[
			"Jeffadmin./assets/plugins/tempus-dominus-6.0.0/dist/css/tempus-dominus.min",
			"Jeffadmin./assets/plugins/summernote-0.8.18-dist/summernote-lite.min",
			"Jeffadmin./assets/plugins/bootstrap-select-main/docs/docs/dist/css/bootstrap-select.min",
			//"Jeffadmin./assets/plugins/icheck-1.0.3/skins/all",

			// "Jeffadmin./assets/plugins/select2-4.1.0-rc.0/dist/css/select2.min",	// If you want to use Select 2, but it's not finish!!!
			// "Jeffadmin./assets/css/select2-bootstrap-5-theme.min",					// If you want to use Select 2, but it's not finish!!!
		],
		['block' => true]);


	$this->Html->script(
		[
			"Jeffadmin./assets/js/popper",
			"Jeffadmin./assets/plugins/tempus-dominus-6.0.0/dist/js/tempus-dominus.min",	// Must be loaded the popper.js !!
			"Jeffadmin./assets/plugins/bootstrap-input-spinner-bs-5/src/bootstrap-input-spinner",
			"Jeffadmin./assets/plugins/summernote-0.8.18-dist/summernote-lite.min",
			"Jeffadmin./assets/plugins/summernote-0.8.18-dist/lang/summernote-hu-HU",
			//'Jeffadmin./assets/plugins/jReadMore-master/dist/read-more.min',
			"Jeffadmin./assets/plugins/bootstrap-select-main/docs/docs/dist/js/bootstrap-select.min",
			"Jeffadmin./assets/plugins/bootstrap-select-main/docs/docs/dist/js/i18n/defaults-hu_HU.min",
			//"Jeffadmin./assets/plugins/icheck-1.0.3/icheck.min",
			
			//"Jeffadmin./assets/plugins/jquery-copy-to-clipboard-master/jquery.copy-to-clipboard",
			
			//'Jeffadmin./assets/plugins/select2-4.1.0-rc.0/dist/js/select2.full.min',	// If you want to use Select 2, but it's not finish!!!
			//'Jeffadmin./assets/plugins/select2-4.1.0-rc.0/dist/js/i18n/hu',			// If you want to use Select 2, but it's not finish!!!
		],
		['block' => 'scriptBottom']
	); ?>
		
<?php
	// SELECT: https://developer.snapappointments.com/bootstrap-select/examples/
?>

<?php $this->Html->scriptStart(['block' => 'javaScriptBottom']); ?>

	jeffAdminInitSelectPicker()
	jeffAdminInitInputSpinner()
	jeffAdminInitSummerNote('text', 400, '<?= __("Here you can write the note") ?>...') // Init SummerNote for text.
	//jeffAdminInitICheck('icheckbox_flat-blue');

	$(document).ready( function(){
		$('#button-submit').click( function(){
			$('#main-form').submit();
		});			
	});			

<?php $this->Html->scriptEnd(['block' => 'javaScriptBottom']); ?>

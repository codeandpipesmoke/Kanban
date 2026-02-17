<!doctype html>
<html>
<head>
	<title>Kanban</title>
	<meta name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
<?php
	echo $this->Html->script([
		'/plugins/kanban/codebase/webix/webix.js?v=11.3.1',
		'/plugins/kanban/codebase/kanban.js?v=11.3.1',
		]);

	echo $this->Html->css([
		'/plugins/kanban/codebase/webix/webix.css?v=11.3.1',
		'/plugins/kanban/codebase/kanban.css?v=11.3.1'
	])
?>

	<style>
		.toolbar{
			background-color: #f8f8f8;
		}
	</style>
</head>
<body>
	<?= $this->fetch('content') ?>
</body>
</html>
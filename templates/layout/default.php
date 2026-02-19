<!doctype html>
<html>
<head>
	<title>Kanban</title>
	<meta name = "viewport" content = "initial-scale = 1.0, maximum-scale = 1.0, user-scalable = no">
<?php
	echo $this->Html->script([
		'/plugins/kanban/codebase/webix/webix_csrf.js?v=11.3.1',
		'/plugins/kanban/codebase/kanban.js?v=11.3.1',
		//'/plugins/kanban/codebase/webix/webix',
		//'/plugins/kanban/codebase/kanban',
		//'/plugins/kanban/samples/common/data',
	]);

	echo $this->Html->css([
		'/plugins/kanban/codebase/webix/webix.css?v=11.3.1',
		'/plugins/kanban/codebase/kanban.css?v=11.3.1'
		//'/plugins/kanban/codebase/webix/webix',
		//'/plugins/kanban/codebase/kanban'
	]);
?>

	<style>
		.toolbar{
			background-color: #f8f8f8;
		}
		.shadow{
			box-shadow: inset 0 1px 3px #aaa;
		}
		.webix_kanban_list_content {
			border-left: 5px solid lightgray;
		}
		.priority .webix_kanban_list_content{
			background-color: #fff2c1;
			border-color:  #e0d7b7;
			border-left-color:  #f5cf3d;
		}
		.priority.webix_selected .webix_kanban_list_content{
			background-color: #fff1a2;
		}
	</style>
</head>
<body>
<?= $this->fetch('content') ?>

</body>
</html>
<script type="text/javascript">
	<?= sprintf('const csrfToken = %s;', json_encode($this->request->getAttribute('csrfToken'))); ?>

	const apiRoot = "/tasks";

	function remove(){
		var id = $$("myBoard").getSelectedId();
		if(!id){
			return webix.alert("Please selected a card that you want to remove!");
		}
		$$("myBoard").remove(id);
	}

	webix.ready(function(){
		webix.CustomScroll.init();

		webix.ui({
			rows:[
				{
					css: "toolbar",
					borderless: true,
					paddingY:7,

					paddingX:10,
					margin: 7,
					cols:[
						//{ view: "label", label: "You can add and remove cards in Kanban Board"},
						//{ view: "button", type: "danger", label: "Remove selected", click: remove, width: 150},
						{ view: "button", type: "form",  label: "Add new card", width: 150, click:() => {
							$$("myBoard").showEditor();
						}}
					]
				},
				{
					view:"kanban",
					id: "myBoard",

					cols: <?= $cols ?>,
					tags: <?= $tags ?>,
					colors: <?= $colors ?>,
					data: <?= $data ?>,
					
					//url: apiRoot + "/tasks/index",
					save:{
						url: "json->" + apiRoot + "/update",
						trackMove: true
					},
					
					userList:true,
					editor:true,
					users: users_set
				}
			]
		});
	});
</script>



<?php /*
<script type="text/javascript">
	webix.ready(function(){
		webix.CustomScroll.init();

		webix.ui({
			rows:[
				{
					css: "toolbar",
					borderless: true,
					paddingY:7,
					paddingX:10,
					margin: 7,
					cols:[
						{ view: "label", label: "You can add and remove cards in Kanban Board"},
						{ view: "button", type: "danger", label: "Remove selected", width: 150, click:() => {
							var id = $$("myBoard").getSelectedId();
							if(!id){
								return webix.alert("Please selected a card that you want to remove!");
							}
							$$("myBoard").remove(id);
						}},
						{ view: "button", type: "form",  label: "Add new card", width: 150, click:() => {
							$$("myBoard").showEditor();
						}}
					]
				},
				{
					view:"kanban", 
					id: "myBoard",
					//cols: <?= $cols ?>,
					//tags: <?= $tags ?>,
					//colors: <?= $colors ?>,
					//data: <?= $data ?>,

					tags: tags_set,
					users: users_set,
					colors: colors_set
					data: full_task_set,
					
					userList:false,
					editor:true,
					
					//url: apiRoot + "/tasks/common",
					//save:{
					//	url: "json->" + apiRoot + "/tasks/common",
					//	trackMove: true
					//},

					users: users_set,
				}
			]
		});
	});
</script>

<?php /*
<script type="text/javascript">
	const apiRoot = "/tasks/api";

	function remove(){
		var id = $$("myBoard").getSelectedId();
		if(!id){
			return webix.alert("Please selected a card that you want to remove!");
		}
		$$("myBoard").remove(id);
	}

	webix.ready(function(){
		webix.CustomScroll.init();

		webix.ui({
			rows:[
				{
					css: "toolbar",
					borderless: true,
					paddingY:7,
				
					paddingX:10,
					margin: 7,
					cols:[
						{ view: "label", label: "You can add and remove cards in Kanban Board"},
						{ view: "button", type: "danger", label: "Remove selected", click: remove, width: 150},
						{ view: "button", type: "form",  label: "Add new card", width: 150, click:() => {
							$$("myBoard").showEditor();
						}}
					]
				},
				{
					view:"kanban",
					id: "myBoard",
					
					//cols: <?php //= $cols ?>,
					//tags: <?php //= $tags ?>,
					//colors: <?php //= $colors ?>,

					userList:true,
					editor:true,
					data: full_task_set,
					tags: tags_set,
					users: users_set,
					colors: colors_set
				}
			]
		});
	});
</script>

<?php /*
*/ ?>

<?php /*
<script type="text/javascript">
	webix.ready(function(){
		webix.CustomScroll.init();

		webix.ui({
			rows:[
				{
					css: "toolbar",
					borderless: true,
					paddingY:7,
					paddingX:10,
					margin: 7,
					cols:[
						{ view: "label", label: "You can add and remove cards in Kanban Board"},
						{ view: "button", type: "danger", label: "Remove selected", width: 150, click:() => {
							var id = $$("myBoard").getSelectedId();
							if(!id){
								return webix.alert("Please selected a card that you want to remove!");
							}
							$$("myBoard").remove(id);
						}},
						{ view: "button", type: "form",  label: "Add new card", width: 150, click:() => {
							$$("myBoard").showEditor();
						}}
					]
				},
				{
					view:"kanban", 
					id: "myBoard",
					cols:[
						{ header:"Backlog", 	body:{ view:"kanbanlist", status:"new" }},
						{ header:"In Progress", body:{ view:"kanbanlist", status:"work" }},
						{ header:"Testing",		body:{ view:"kanbanlist", status:"test" }},
						{ header:"Done",		body:{ view:"kanbanlist", status:"done" }}
					],
					userList:true,
					editor:true,
					data: full_task_set,
					tags: tags_set,
					users: users_set,
					colors: colors_set
				}
			]
		});
	});
</script>
*/ ?>

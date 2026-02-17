<script type="text/javascript">
	const apiRoot = "/api/v1";


	//cols:[
	//	{ header:"Backlog", body:{ view:"kanbanlist", status:"new", type: "tasks"}},
	//	{ header:"In Progress", body:{ view:"kanbanlist", status:"work", type: "tasks"}},
	//	{ header:"Testing", body:{ view:"kanbanlist", status:"test", type: "tasks"}},
	//	{ header:"Done", body:{ view:"kanbanlist", status:"done", type: "tasks"}}
	//],

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
					
					cols: cols,
					
					//cols:[
					//	{ header:"Backlog", body:{ view:"kanbanlist", status:"new", type: "tasks"}},
					//	{ header:"In Progress", body:{ view:"kanbanlist", status:"work", type: "tasks"}},
					//	{ header:"Testing", body:{ view:"kanbanlist", status:"test", type: "tasks"}},
					//	{ header:"Done", body:{ view:"kanbanlist", status:"done", type: "tasks"}}
					//],
					
					//url: apiRoot + "/tasks",
					url: apiRoot,
					
					save:{
						url: "json->" + apiRoot + "/tasks/common",
						trackMove: true
					},
					
					userList:true,
					editor:true,
					tags: tags_set,
					users: users_set,
					colors: colors_set
				}
			]
		});
	});
</script>
<?php
return [
	'Theme' => [
		'admin' => [
			'sidebar' => [
				'title' => 'JeffAdmin',
				
			],
			'sidebarMenu' => [
				'Admin' => [
					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Tasks'),
						'controller'=> 'Tasks',
						'action' 	=> 'index',
					],
/*
					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Comments'),
						'controller'=> 'Comments',
						'action' 	=> 'index',
					],
*/
					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Projects'),
						'controller'=> 'Projects',
						'action' 	=> 'index',
					],

					[
						'type' 		=> 'submenu',
						'title'		=> __('Project setups'),
						'icon'		=> 'fa fa-fw fa-table',
						'items'		=> [
							[
								'title'		=> __('Cols'),
								'controller'=> 'Cols',
								'action' 		=> 'index',								
							],
							[
								'title'		=> __('Colors'),
								'controller'=> 'Colors',
								'action' 		=> 'index',								
							],
							[
								'title'		=> __('Tags'),
								'controller'=> 'Tags',
								'action' 		=> 'index',								
							],
						]
					],


				],				
			]		
		]	
	],

];

?>

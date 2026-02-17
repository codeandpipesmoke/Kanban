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
					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Cols'),
						'controller'=> 'Cols',
						'action' 	=> 'index',
					],


					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Tags'),
						'controller'=> 'Tags',
						'action' 	=> 'index',
					],
					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Colors'),
						'controller'=> 'Colors',
						'action' 	=> 'index',
					],
					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Statuses'),
						'controller'=> 'Statuses',
						'action' 	=> 'index',
					],
					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Views'),
						'controller'=> 'Views',
						'action' 	=> 'index',
					],
					[
						'type' 		=> 'menu',
						'icon' 		=> 'fa fa-fw fa-bars',
						'title'		=> __('Projects'),
						'controller'=> 'Projects',
						'action' 	=> 'index',
					],
/*
					[
						'type' 		=> 'submenu',
						'title'		=> __('Tables'),
						'icon'		=> 'fa fa-fw fa-table',
						'items'		=> [
							[
								'title' 		=> __('Posts'),
								'controller' 	=> 'Posts',
								'action' 		=> 'index',								
							],
							[
								'title' 		=> __('Categories'),
								'controller' 	=> 'Categories',
								'action' 		=> 'index',								
							],
						]
					],
*/
				],				
			]		
		]	
	],

];

?>

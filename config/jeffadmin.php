<?php
return [
	'Theme' => [
		'admin' => [
			'config' => [
				'controller' => [
					'paginate_limit' 			=> 20,
				
				],
				'template' => [
					'index' => [
						'show_id' 					=> true,
						'show_pos' 					=> true,
						'show_visible' 				=> true,
						'show_counters'				=> true,
						'show_created' 				=> true,
						'show_modified' 			=> true,
						'show_button_view'			=> true,
						'show_button_edit'			=> true,
						'show_button_delete'		=> true,
						'action_db_click'			=> 'edit',	// none, edit or view
					],
					'view' => [
						'show_related_tables'		=> true,
						'show_id' 					=> true,
						'show_pos' 					=> true,
						'show_visible' 				=> true,
						'show_counters'				=> true,
						'show_created' 				=> true,
						'show_modified' 			=> true,
						'index_show_id' 			=> true,
						'index_show_pos' 			=> true,
						'index_show_visible' 		=> true,
						'index_show_counters'		=> true,
						'index_show_created' 		=> true,
						'index_show_modified' 		=> true,
						'index_show_button_view'	=> true,
						'index_show_button_edit'	=> true,
						'index_show_button_delete'	=> true,
					],
				],
				
				// Standard actions buttons. If yíou want to add new, you can take it in controller action... later... ;-)
				'header_buttons_in_action' => [
					'index' => ['back' => false, 'add' => true,  'edit' => false, 'save' => false, 'view' => false, 'delete' => false],
					'add' 	=> ['back' => true,  'add' => false, 'edit' => false, 'save' => true,  'view' => false, 'delete' => false],
					'edit' 	=> ['back' => true,  'add' => true,  'edit' => false, 'save' => true,  'view' => true,  'delete' => true],
					'view' 	=> ['back' => true,  'add' => true,  'edit' => true,  'save' => false, 'view' => false, 'delete' => true],
				],
			],
		],
	],
];

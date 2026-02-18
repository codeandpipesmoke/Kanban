<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class TasksController extends AppController
{
	private $Cols 		= null;
	private $Colors 	= null;
	private $Tags 		= null;
	//private $Statuses	= null;
	//$Users 		= null;

	
	public function viewClasses(): array
    {
        return [\Cake\View\JsonView::class];
    }

	
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
	public function initialize(): void
    {
        parent::initialize();

		$this->Cols = $this->fetchTable('Cols');		
		$this->Colors = $this->fetchTable('Colors');
		$this->Tags = $this->fetchTable('Tags');
		//$this->Statuses = $this->fetchTable('Statuses');
		
		//$this->Tasks = $this->fetchTable('Tasks');
		//$this->Users = $this->fetchTable('Users');

        //$this->loadComponent('Flash');
	
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($project = 'kanbanlist')
    {
		/*
		cols:[
			{ header:"Backlog", body:{ view:"kanbanlist", status:"new", type: "tasks"}},
			{ header:"Done", body:{ view:"kanbanlist", status:"done", type: "tasks"}}
		],
		*/
        $cols = $this->Cols->find()->select(['id', 'header' => 'Cols.name', 'view' => 'Views.name', 'status', 'type' => 'Types.name'])
			->contain(['Views', 'Types'])
			//->where(['views.name' => $project])
			->where(['Cols.visible' => true])
			->orderBy(['Cols.pos' => 'asc', 'Cols.name' => 'asc'])
			;
		//dd($cols->toArray());
		
		$col_array = [];
		foreach($cols as $col){
			$col_array[] = [
				'header' => $col->header,
				'body' => [
					'view' => $col->view,
					'status' => $col->status,
					'type' => $col->type,
				]
			];
		}
		$cols = json_encode($col_array, JSON_UNESCAPED_UNICODE);	// Dekódoljuk, majd újra kódoljuk ékezetekkel, de szóközök nélkül
		$cols = preg_replace('/"([^"]+)":/', '$1:', $cols); // Eltávolítjuk az idézőjeleket a kulcsok mellől (RegEx: "kulcs": -> kulcs:)
		$this->set('cols', $cols);
		

		/*
		var tags_set = [
			{id:1, value:"webix "},
			{id:2, value:"jet 2"},
		];
		*/
        $tags = $this->Tags->find()
			->select(['id', 'value' => 'name'])
			//->contain(['Views', 'Statuses', 'Types'])
			->where(['Tags.visible' => true])
			->orderBy(['Tags.pos' => 'asc', 'Tags.name' => 'asc'])
			;
		$tags_array = [];
		foreach($tags as $tag){
			$tags_array[] = [
				'id' => $tag->id,
				'value' => $tag->value,
			];
		}
		$tags = json_encode($tags_array, JSON_UNESCAPED_UNICODE);	// Dekódoljuk, majd újra kódoljuk ékezetekkel, de szóközök nélkül
		$tags = preg_replace('/"([^"]+)":/', '$1:', $tags); // Eltávolítjuk az idézőjeleket a kulcsok mellől (RegEx: "kulcs": -> kulcs:)
		$this->set('tags', $tags);


		/*
		var colors_set = [
			{id:1, value:"Normal", color:"green"},
			{id:2, value:"Low", color:"orange"},
			{id:3, value:"Urgent", color:"red"}
		];
		*/
        $colors = $this->Colors->find()	
			->select(['id', 'name', 'color'])
			//->contain(['Views', 'Statuses', 'Types'])
			//->where(['views.name' => $project])
			->where(['Colors.visible' => true])
			->orderBy(['pos' => 'asc', 'name' => 'asc'])
			;
		$colors_array = [];
		foreach($colors as $color){
			//debug($color);
			$colors_array[] = [
				'id' => $color->id,
				'value' => $color->name,
				'color' => strtoupper($color->color),
			];
		}
		$colors = json_encode($colors_array, JSON_UNESCAPED_UNICODE);	// Dekódoljuk, majd újra kódoljuk ékezetekkel, de szóközök nélkül
		$colors = preg_replace('/"([^"]+)":/', '$1:', $colors); // Eltávolítjuk az idézőjeleket a kulcsok mellől (RegEx: "kulcs": -> kulcs:)
		$this->set('colors', $colors);




		/*
		var full_task_set = [
			{ id:1, status:"new", text:"Test new authentification service", tags:[1,2,3] },
			{ id:2, status:"work", user_id: 5, text:"Performance tests 11", tags:[1] }
		];
		*/
        $tasks = $this->Tasks->find()	
			//->select(['id' => 'Tasks.id', 'user_id' => 1, 'text' => 'Tasks.name', ])
			->contain(['Colors', 'Cols', 'Tags' => ['conditions' =>['Tags.visible' => true]]])
			->where(['Tasks.deleted' => false, 'Tasks.visible' => true, 'Colors.visible' => true])
			->orderBy(['Tasks.pos' => 'asc', 'Tasks.name' => 'asc'])
			;
			
		//dd($tasks->toArray());
			
		$tasks_array = [];
		foreach($tasks as $task){
			//debug($tasks->toArray());
			$tags = [];
			foreach($task->tags as $tag){
				$tags[] = $tag->id;
			}
			$tasks_array[] = [
				'id' => $task->id,
				'user_id' => 1,
				'status' => $task->col->status,
				'color' => strtoupper($task->color->color),
				//'text' => $task->id . ' - ' . $task->name,
				'text' => $task->name,
				'tags' => $tags
			];
		}
		$tasks = json_encode($tasks_array, JSON_UNESCAPED_UNICODE);	// Dekódoljuk, majd újra kódoljuk ékezetekkel, de szóközök nélkül
		$tasks = preg_replace('/"([^"]+)":/', '$1:', $tasks); // Eltávolítjuk az idézőjeleket a kulcsok mellől (RegEx: "kulcs": -> kulcs:)
		//dd($tasks);
		$this->set('data', $tasks);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
	/*
	object(stdClass) id:0 {
		id => (int) 4 
		user_id => '1' 
		status => 'todo' 
		text => 'Számlázóban Hitelkrátya befizetéseket auomatikusan elrakni, ne kerüljön a Csoportos befizetések közé' 
		tags => [
			(int) 0 => '2', 
			(int) 1 => '3', 
			(int) 2 => '4', 
			(int) 3 => '5', 
			(int) 4 => '6',
		]
		color => '2'
		}
	*/
	//$data = '{"id":4,"user_id":"1","status":"todo","text":"Számlázóban Hitelkrátya befizetéseket auomatikusan elrakni, ne kerüljön a Csoportos befizetések közé","tags":["2","3","4","5","6"],"color":"2"}';
	// { id:2, status:"work", text:"Task 2", color:"#FE0E0E", tags:"webix", votes:1, personId: 4  },
	//dd(json_decode($data));
	
	// Törlés: {"text":"Teszt kanban","tags":["1"],"user_id":"1","color":"2","status":"test","id":1771413640513}
	// {"id":7,"user_id":1,"status":"delete","color":"#00cc66","text":"7 - Hátralékosok kezelése (legyűjtése, átnézése, felszólító kiküldése, átadása)","tags":[6]}
	
    public function update()
    {
		if ($this->request->is('delete')) {
			// Az érkező JSON adatok beolvasása
			$jsonData = $this->request->getData();
			$task = $this->Tasks->get((int) $jsonData['id']);
			//$jsonData['deleted'] = true;
			$task = $this->Tasks->patchEntity($task, $jsonData);
			$task->deleted = true;
			$col = $this->Cols->findByStatus('deleted')->first();
			$task->col_id = $col->id;
			//dd($task->getErrors());
			if ($this->Tasks->save($task)) {
				$message = 'Sikeres törlés!';
				$success = true;
			} else {
				$message = 'Hiba történt a törlés során.';
				$success = false;
			}

			// JSON válasz visszaadása az AJAX hívásnak
			return $this->response
				->withType('application/json')
				->withStringBody(json_encode([
					'success' => $success,
					'message' => $message
				]));
		}




		//ÚJ: {"text":"sdasd","tags":["3","4"],"user_id":"1","color":"1","status":"test"}

		$this->request->allowMethod(['post', 'put']);
		$jsonData = $this->request->getData();

		// Ha új
		if(!isset($jsonData['id'])){
			$task = $this->Tasks->newEmptyEntity();
			//$task = $this->Tasks->patchEntity($task, $jsonData);
		}else{
			$task = $this->Tasks->findById($jsonData['id'])->first();
			if(null === $task){
				$task = $this->Tasks->findByName($jsonData['text'])->orderBy(['created' => 'desc'])->first();	// Mert a kanban.js időnként kitalál ID-t és az alapján nem lehet megtalálni.
			}
		}

		$jsonData['name'] = $jsonData['text'];

		//$col = $this->Cols->findByStatus($jsonData['status'])->first();
		//$jsonData['status'] = $col->id;

		$color = $this->Colors->findByColor($jsonData['color'])->first();
		$jsonData['color_id'] = $color->id ?? $jsonData['color'];
		
		// 2. Adatátalakítás a Many-to-Many mentéshez
		// A CakePHP a '_ids' kulcsot várja a kapcsolótábla frissítéséhez
		if (isset($jsonData['tags']) && is_array($jsonData['tags'])) {
			$jsonData['tags'] = ['_ids' => $jsonData['tags']];
		}

		/*
		[
			'id' => (int) 4, 
			'user_id' => (int) 1, 
			'status' => 'done', 
			'text' => '4 - Számlázóban Hitelkrátya befizetéseket auomatikusan elrakni, ne kerüljön a Csoportos befizetések közé',
			'tags' => [
				'_ids' => [
					(int) 0 => (int) 2,
					(int) 1 => (int) 3,
					(int) 2 => (int) 4,
				],
			],
			'webix_move_index' => (int) 0,
			'webix_move_parent' => 'done',
		]
		*/
		
		unset($jsonData['color']);		
		unset($jsonData['user_id']);
		unset($jsonData['webix_move_index']);
		unset($jsonData['webix_move_parent']);
		
		// 3. Adatok összefésülése az entity-vel


		// Ha új
		//if(!isset($jsonData['id'])){
		//	$task = $this->Tasks->newEmptyEntity();
		//}
		$task = $this->Tasks->patchEntity($task, $jsonData);
		//dd($jsonData);
		$status = $this->Cols->findByStatus($jsonData['status'])->first();
		$task->col_id  = $status->id;

		// 4. Mentés és válasz küldése
		//dd($task->getErrors());
		if ($this->Tasks->save($task)) {
			$message = 'Sikeres mentés!';
			$success = true;
		} else {
			$message = 'Hiba történt a mentés során.';
			$success = false;
			// Debugoláshoz: $errors = $task->getErrors();
		}

		// JSON válasz visszaadása az AJAX hívásnak
		return $this->response
			->withType('application/json')
			->withStringBody(json_encode([
				'success' => $success,
				'message' => $message
			]));
		
		
		
	}

}

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
	
//	public function viewClasses(): array
//    {
//        return [\Cake\View\JsonView::class];
//    }

	
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
        $cols = $this->Cols->find()->select(['id', 'header' => 'Cols.name', 'view' => 'Views.name', 'status', 'type' => 'Types.name'])
			->contain(['Views', 'Types'])
			//->where(['views.name' => $project])
			->where(['Cols.visible' => true])
			->orderBy(['Cols.pos' => 'asc', 'Cols.name' => 'asc'])
			;
		
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
		

        $tags = $this->Tags->find()
			->select(['id', 'value' => 'name'])
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


        $colors = $this->Colors->find()	
			->select(['id', 'name', 'color'])
			->where(['Colors.visible' => true])
			->orderBy(['pos' => 'asc', 'name' => 'asc'])
			;
		$colors_array = [];
		foreach($colors as $color){
			$colors_array[] = [
				'id' => $color->id,
				'value' => $color->name,
				'color' => strtoupper($color->color),
			];
		}
		$colors = json_encode($colors_array, JSON_UNESCAPED_UNICODE);	// Dekódoljuk, majd újra kódoljuk ékezetekkel, de szóközök nélkül
		$colors = preg_replace('/"([^"]+)":/', '$1:', $colors); // Eltávolítjuk az idézőjeleket a kulcsok mellől (RegEx: "kulcs": -> kulcs:)
		$this->set('colors', $colors);



        $tasks = $this->Tasks->find()	
			//->select(['id' => 'Tasks.id', 'user_id' => 1, 'text' => 'Tasks.name', ])
			->contain(['Colors', 'Cols', 'Tags' => ['conditions' =>['Tags.visible' => true]]])
			->where(['Tasks.deleted' => false, 'Tasks.visible' => true, 'Colors.visible' => true])
			->orderBy(['Tasks.pos' => 'asc', 'Tasks.name' => 'asc'])
			;
			
		$tasks_array = [];
		foreach($tasks as $task){
			$tags = [];
			foreach($task->tags as $tag){
				$tags[] = $tag->id;
			}
			$tasks_array[] = [
				'id' => $task->id,
				'user_id' => 1,
				'status' => $task->col->status,
				'color' => strtoupper($task->color->color),
				'text' => $task->name,
				'tags' => $tags
			];
		}
		$tasks = json_encode($tasks_array, JSON_UNESCAPED_UNICODE);	// Dekódoljuk, majd újra kódoljuk ékezetekkel, de szóközök nélkül
		$tasks = preg_replace('/"([^"]+)":/', '$1:', $tasks); // Eltávolítjuk az idézőjeleket a kulcsok mellől (RegEx: "kulcs": -> kulcs:)
		$this->set('data', $tasks);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function update()
    {
		// ############################# DELETE #############################
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


		// ############################# UPDATE #############################
		$this->request->allowMethod(['post', 'put']);
		$jsonData = $this->request->getData();

		if(!isset($jsonData['id'])){
			$task = $this->Tasks->newEmptyEntity();		// Ha új
			//$task = $this->Tasks->patchEntity($task, $jsonData);
		}else{
			$task = $this->Tasks->findById((int) $jsonData['id'])->first();
			if(null === $task){
				$task = $this->Tasks->findByName($jsonData['text'])->orderBy(['created' => 'desc'])->first();	// Mert a kanban.js időnként kitalál ID-t és az alapján nem lehet megtalálni.
			}
		}

		$jsonData['name'] = $jsonData['text'];
		
		// 2. Adatátalakítás a Many-to-Many mentéshez
		// A CakePHP a '_ids' kulcsot várja a kapcsolótábla frissítéséhez
		if (isset($jsonData['tags']) && is_array($jsonData['tags'])) {
			$jsonData['tags'] = ['_ids' => $jsonData['tags']];
		}
		
		unset($jsonData['user_id']);
		unset($jsonData['webix_move_index']);
		unset($jsonData['webix_move_parent']);
		
		$task = $this->Tasks->patchEntity($task, $jsonData);

		$color = $this->Colors->findById((int) $jsonData['color'])->first();
		if(null === $color){
			$color = $this->Colors->findByColor($jsonData['color'])->first();
		}
		$task->color_id = $color->id ?? 0;
		

		$col = $this->Cols->findByStatus($jsonData['status'])->first();
		$task->col_id = $col->id;

		if ($this->Tasks->save($task)) {
			$message = 'Sikeres mentés!';
			$success = true;
		} else {
			$message = 'Hiba történt a mentés során.';
			$success = false;
			// Debugoláshoz: $errors = $task->getErrors();
			// dd($task->getErrors());
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

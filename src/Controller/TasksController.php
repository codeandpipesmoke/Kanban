<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\I18n\DateTime;

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
	private $Comments	= null;
	
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
		$this->Comments = $this->fetchTable('Comments');
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
		$this->set('currentUserId', 1);
		
        $cols = $this->Cols->find()->select(['id', 'header' => 'Cols.name', 'status'])
			->where(['Cols.visible' => true])
			->orderBy(['Cols.pos' => 'asc', 'Cols.name' => 'asc'])
			;
		
		$col_array = [];
		foreach($cols as $col){
			$col_array[] = [
				'header' => $col->header,
				'body' => [
					'status' => $col->status,
					'view' => 'kanbanlist',
					'type' => 'tasks',
				]
			];
		}
		$cols = json_encode($col_array, JSON_UNESCAPED_UNICODE);	// Kódoljuk ékezetekkel, de szóközök nélkül
		$cols = preg_replace('/"([^"]+)":/', '$1:', $cols); 		// Eltávolítjuk az idézőjeleket a kulcsok mellől (RegEx: "kulcs": -> kulcs:)
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
		$tags = json_encode($tags_array, JSON_UNESCAPED_UNICODE);
		$tags = preg_replace('/"([^"]+)":/', '$1:', $tags);
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
		$colors = json_encode($colors_array, JSON_UNESCAPED_UNICODE);
		$colors = preg_replace('/"([^"]+)":/', '$1:', $colors);
		$this->set('colors', $colors);


        $tasks = $this->Tasks->find()	
			->contain(['Colors', 'Cols', 'Comments', 'Tags'])
			->where(['Tasks.deleted' => false, 'Tasks.visible' => true, 'Colors.visible' => true])
			// Sajnos a jó sorrendet nem lehet megtartani, mert csak egy kártya pozícija mentédik. És mi van, ha van már egy olyan?
			// Ezért a modified mező desc még hozzá. Hátha...
			->orderBy(['Cols.pos' => 'asc', 'Tasks.position' => 'asc', 'Tasks.modified' => 'desc'])
			;

		$tasks_array = [];
		foreach($tasks as $task){
			$tags = [];
			foreach($task->tags as $tag){
				$tags[] = $tag->id;
			}

			$comments = [];
			foreach($task->comments as $comment){
				$comments[] = [
					'id' => $comment->id,
					'user_id' => $comment->user_id,
					'date' => $comment->created->format('Y-m-d H:i'),					
					'text' => $comment->text,
				];
			}

			$tasks_array[] = [
				'id' => $task->id,
				'user_id' => $task->user_id,
				'status' => $task->col->status,
				'color' => strtoupper($task->color->color),
				'text' => $task->name,
				'tags' => $tags,
				'comments' => $comments,
				'$css' => $task->priority ? 'priority' : '',
			];
		}
		$tasks = json_encode($tasks_array, JSON_UNESCAPED_UNICODE);	// Dekódoljuk, majd újra kódoljuk ékezetekkel, de szóközök nélkül
		$tasks = preg_replace('/"([^"]+)":/', '$1:', $tasks); // Eltávolítjuk az idézőjeleket a kulcsok mellől (RegEx: "kulcs": -> kulcs:)
		$this->set('data', $tasks);
    }
	
	
    /**
     * Update method
     *
     * @return ...
     */
    public function update()
    {
		// ############################# DELETE #############################
		/*
			megjegyzés, hogy az N:M kapcsolat táblában lévő adatokat törli, de a commenteket nem.
			A Commentekhez be kell tenni egy kaszkásolt törlést a modelbe.
		*/
		if ($this->request->is('delete')) {
			// Az érkező JSON adatok beolvasása
			$jsonData = $this->request->getData();
			$task = $this->Tasks->get((int) $jsonData['id'], contain: ['Comments', 'Tags']);
			//debug($task->toArray());
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
			//dd($task->toArray());

			// JSON válasz visszaadása az AJAX hívásnak
			return $this->response
				->withType('application/json')
				->withStringBody(json_encode([
					'success' => $success,
					'message' => $message
				]));
		}


		// ############################# UPDATE #############################
		// ############################# UPDATE #############################
		// ############################# UPDATE #############################
		// ############################# UPDATE #############################
		// ############################# UPDATE #############################
		// ############################# UPDATE #############################
		// ############################# UPDATE #############################
		$this->request->allowMethod(['post', 'put']);
		$jsonData = $this->request->getData();
		
		
		if(!isset($jsonData['id'])){
			$task = $this->Tasks->newEmptyEntity();		// Ha új
		}else{
			$task = $this->Tasks->findById((int) $jsonData['id'])->first();
			if(null === $task){
				$task = $this->Tasks->findByName($jsonData['text'])->orderBy(['created' => 'desc'])->first();	// Mert a kanban.js időnként kitalál ID-t és az alapján nem lehet megtalálni.
			}
		}

		$jsonData['name'] = $jsonData['text'];
		
		// 2. Adatátalakítás a Many-to-Many mentéshez. A CakePHP a '_ids' kulcsot várja a kapcsolótábla frissítéséhez
		if (isset($jsonData['tags']) && is_array($jsonData['tags'])) {
			$jsonData['tags'] = ['_ids' => $jsonData['tags']];
		}
		
		//unset($jsonData['user_id']);
		//unset($jsonData['webix_move_index']);
		//unset($jsonData['webix_move_parent']);
		//webix_move_id
		
		$jsonDataWithoutComments = $jsonData;
		
		unset($jsonDataWithoutComments['comments']);
		$task = $this->Tasks->patchEntity($task, $jsonDataWithoutComments);

		if(isset($jsonData['color'])){
			$color = $this->Colors->findById((int) $jsonData['color'])->first();
			if(null === $color){
				$color = $this->Colors->findByColor($jsonData['color'])->first();
			}
			$task->color_id = $color->id ?? 0;
		}
		

		$col = $this->Cols->findByStatus($jsonData['status'])->first();
		$task->col_id = $col->id;

		// oszlopon belüli pozíció
		if(isset($jsonData["webix_move_index"]) && null !== $jsonData["webix_move_index"]){
			$task->position = $jsonData["webix_move_index"];
		}
			
		if(isset($jsonData['user_id'])){
			$task->user_id = $jsonData['user_id'];
		}
			
		// Save Task
		$message = 'Sikeres mentés!';
		$success = true;		
		//dd($task->getErrors());		
		if ($this->Tasks->save($task)) {
			
			//dd($task->toArray());
			
			// Save Comments			
			foreach($jsonData['comments'] as $jsonComment){
				unset($jsonComment['date']);
				$comment = $this->Comments->find()->where(['id' => $jsonComment['id']]);
				if($comment->count() === 0){
					$data = [];
					$comment 			= $this->Comments->newEmptyEntity();
					$data['id'] 		= $jsonComment['id'];
					$data['task_id'] 	= $task->id;
					$data['user_id'] 	= $jsonComment['user_id'];
					$data['text'] 		= $jsonComment['text'];
					$comment = $this->Comments->patchEntity($comment, $data);				
					if (!$comment->hasErrors() && $this->Comments->save($comment)) {
						$message = 'Sikeres mentés (komment is)!';
						$success = true;
					}else{
						$message = 'Hiba történt a kommentek mentése során.';
						$success = false;
					}
				}
			}
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

<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\Api\AppController;

/**
 * Tasks Controller
 *
 * @property \App\Model\Table\TasksTable $Tasks
 */
class V1Controller extends AppController
{
	private $Cols 		= null;
	private $Colors 	= null;
	private $Tags 		= null;
	private $Tasks 		= null;
	//$Users 		= null;
	
	
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
		$this->Tasks = $this->fetchTable('Tasks');
		//$this->Users = $this->fetchTable('Users');

        //$this->loadComponent('Flash');
	
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/5/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }
	
	public function viewClasses(): array
    {
        return [\Cake\View\JsonView::class];
    }


/*
	//[
	//	{ header:"Backlog", body:{ view:"kanbanlist", status:"new", type: "tasks"}},
	//	{ header:"In Progress", body:{ view:"kanbanlist", status:"work", type: "tasks"}},
	//	{ header:"Testing", body:{ view:"kanbanlist", status:"test", type: "tasks"}},
	//	{ header:"Done", body:{ view:"kanbanlist", status:"done", type: "tasks"}}
	//]
*/
    public function tasks()
    {
        // Adatok lekérése
        $tasks = $this->paginate($this->Tasks->find()->select(['id', 'text' => 'tasks.text', 'view' => 'views.name']))->contains(['Views']);; //->contains(['Views', 'Statuses', 'Types']);
		
		dd($tasks->toArray());
		
        // Az adatok "átadása" a nézetnek
        $this->set(compact('tasks'));
        
        // Annak meghatározása, hogy mely változók legyenek benne a JSON-ban
        $this->viewBuilder()->setOption('serialize', ['tasks']);
    }


    public function cols()
    {
        // Adatok lekérése
        $tasks = $this->Cols->find()->select(['id', 'header' => 'cols.header', 'view' => 'views.name'])->contain(['Views', 'Statuses', 'Types']);

		//->contains(['Views', 'Statuses', 'Types']);
		
		dd($tasks->toArray());
		
        // Az adatok "átadása" a nézetnek
        $this->set(compact('tasks'));
        
        // Annak meghatározása, hogy mely változók legyenek benne a JSON-ban
        $this->viewBuilder()->setOption('serialize', ['tasks']);
    }

}

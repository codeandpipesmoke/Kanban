<?php
declare(strict_types=1);

namespace App\Controller\Admin;


use App\Controller\Admin\AppController;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;


/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 */
class ProjectsController extends AppController
{
	//public $defaultOrder 	 = ['Pagecategories.name' => 'asc', 'Pages.pos' => 'asc'];	// For example
	public $defaultOrder 	 = ['id' => 'asc'];

    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

	}

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($clearFilter = null)
    {
		//Configure::write('Theme.admin.config.header_buttons_in_action.index', array_merge(Configure::read('Theme.admin.config.header_buttons_in_action.index'), 
		//	['back' => false, 'add' => true, 'edit' => false, 'save' => false, 'view' => false, 'delete' => false]
		//));

		$this->set('title', __('Browse the') . ': ' . __('Projects'));
		
		//$this->config['paginate_limit'] = 1000;
		$queryParams = $this->request->getQuery();
		$conditions 	 = [];		// Default conditions
		$page 		 	 = '1';
		$sort 		 	 = 'id';
		$direction 	 	 = 'asc';
		$showSearchBar	 = false;
		$searchInSession = '';
		$search 	 	 = '';		

		if ($clearFilter == 'clear-filter'){
			if($this->session->check('Layout.' . $this->controller . '.search')){
				$this->session->delete('Layout.' . $this->controller . '.search');
			}
			$showSearchBar	 = true;
		}

		// ############################# SORT ORDER & PAGE ###############################
		if($this->session->check('Layout.' . $this->controller . '.queryparams')){
			$this->queryParamsInSession = json_decode($this->session->read('Layout.' . $this->controller . '.queryparams'));
		}
		
		if(isset($this->queryParamsInSession->page)){
			$page = $this->queryParamsInSession->page;
		}
		
		if(isset($this->queryParamsInSession->sort)){
			$sort = $this->queryParamsInSession->sort;
		}
		
		if(isset($this->queryParamsInSession->direction)){
			$direction = $this->queryParamsInSession->direction;
		}

		if(isset($queryParams['page'])){
			$this->queryParamsInSession->page = $queryParams['page'];
			$page = $this->queryParamsInSession->page;
		}

		if(isset($queryParams['sort'])){
			$this->queryParamsInSession->sort = $queryParams['sort'];
			$sort = $this->queryParamsInSession->sort;
		}

		if(isset($queryParams['direction'])){
			$this->queryParamsInSession->direction = $queryParams['direction'];
			$direction = $this->queryParamsInSession->direction;
		}

		if(!empty($this->queryParamsInSession)){
			$this->session->write('Layout.' . $this->controller . '.queryparams', json_encode($this->queryParamsInSession));
		}

		if($page === null){
			return $this->redirect(['controller' => $this->controller, 'action' => 'index', '?' => array_merge(['page' => 1], $queryParams) ]);
		}

		$this->paginate['Projects']['page'] 	= $page;
		
		if($sort !== null && $direction !== null){
			$this->paginate['Projects']['order'] 	= [$sort => $direction];
		}else{
			$this->paginate['Projects']['order'] 	= $this->defaultOrder;
		}
		
		// ############################# /.SORT ORDER & PAGE ###############################

		// ############################# SEARCH ############################################
		$search = '';
		if($this->session->check('Layout.' . $this->controller . '.search')){
			$search = $this->session->read('Layout.' . $this->controller . '.search');
		}

		if ($this->request->is('post')) {
			$search = $this->request->getData()['search'];
			$this->session->write('Layout.' . $this->controller . '.search', $search);
		}
		// ############################# /.SEARCH ############################################		

		// ############################# QUERY #############################################
		if($search !== ''){
			$showSearchBar	 = true;
			$query = $this->Projects->find()
				->where([
					//$conditions,
					'OR' => [
						'name LIKE' => '%' . $search .  '%',
						//'title LIKE' => '%' . $search .  '%',
						//'value' => (integer) $search,			// Must be convert to integer
					]
				]);
		}else{
			$query = $this->Projects->find()->where($conditions);
		}
		// ############################# /.QUERY ###########################################


		// ############################# PAGINATE ############################################
		try {
			$this->paginate['Projects']['limit'] = $this->config['paginate_limit'];
			$this->paginate['Projects']['maxLimit'] = $this->config['paginate_limit'];
			$projects = $this->paginate($query);
		} catch (NotFoundException $e) {
			// Do something here like redirecting to first or last page.
			// $e->getPrevious()->getAttributes('pagingParams') will give you required info.
			$this->Flash->warning(__($e->getMessage()), ['plugin' => 'Jeffadmin']);
			$paging = $e->getPrevious()->getAttributes('pagingParams')['pagingParams'];
			$requestedPage = $paging['requestedPage'];

			// HU: Ha érvénytelen oldalra akar lapozni az URL-ben, akkor az 1. oldalra irányít át.
			// EN: If you want to page to an invalid page in the URL, it redirects to page 1.
			if ($paging['pageCount'] < $paging['requestedPage']){
                return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'?' => [
						'page'		=> $paging['pageCount'],
						'direction'	=> $direction ?? null,
						'sort'		=> $sort ?? null,
					],
					//'#' => 3
				]);
			}
		}
		// ############################# /.PAGINATE ##########################################

        $this->set('search', $search);
        $this->set('showSearchBar', $showSearchBar);

		if(empty($projects->toArray())){
			return $this->redirect(['action' => 'add']);
		}
		
		$this->set(compact('projects'));
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
		//Configure::write('Theme.admin.config.header_buttons_in_action.view', array_merge(Configure::read('Theme.admin.config.header_buttons_in_action.view'), 
		//	['back' => true, 'add' => true, 'edit' => true, 'save' => false, 'view' => false, 'delete' => true]
		//));

		try {
			$project = $this->Projects->get((int) $id, contain: ['Cols']);
		} catch (\Cake\Datasource\Exception\RecordNotFoundException $exeption) {
			$this->Flash->warning(__($exeption->getMessage()), ['plugin' => 'Jeffadmin']);
			return $this->redirect(['action' => 'index']);
		}

		$this->set('title', __('View the') . ': ' . __('project') . ' ' . __('record'));
		$this->session->write('Layout.' . $this->controller . '.LastId', $id);
		$name = $project->name;
		$this->set(compact('project', 'id', 'name'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
		//Configure::write('Theme.admin.config.header_buttons_in_action.add', array_merge(Configure::read('Theme.admin.config.header_buttons_in_action.add'), 
		//	['back' => true, 'add' => false, 'edit' => false, 'save' => true, 'view' => false, 'delete' => false]
		//));
		
		$this->set('title', __('Add new') . ': ' . __('project') . ' ' . __('record'));
        $project = $this->Projects->newEmptyEntity();
        if ($this->request->is('post')) {
			$data = $this->request->getData();
			//debug($data);
            $project = $this->Projects->patchEntity($project, $data);
			//dd($project);
			/*
				if(...){
					$project->setErrors('field', __('Message'));
				}
			*/
			//dd($project->getErrors());
            if (!$project->hasErrors() && $this->Projects->save($project)) {
                //$this->Flash->success(__('The project has been saved.'), ['plugin' => 'Jeffadmin']);
                $this->Flash->success(__('The save has been: OK'), ['plugin' => 'Jeffadmin']);
				$this->session->write('Layout.' . $this->controller . '.LastId', $project->id);

                //return $this->redirect(['action' => 'add']);
                return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'#' => $project->id
				]);

            }
            //$this->Flash->error(__('The project could not be saved. Please, try again.'), ['plugin' => 'Jeffadmin']);
            $this->Flash->error(__('The save has been not. Please check the datas and try again.'), ['plugin' => 'Jeffadmin']);
        }
        $this->set(compact('project'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
		//Configure::write('Theme.admin.config.header_buttons_in_action.edit', array_merge(Configure::read('Theme.admin.config.header_buttons_in_action.edit'), 
		//	['back' => true, 'add' => true, 'edit' => false, 'save' => true, 'view' => true, 'delete' => true]
		//));

		try {
			$project = $this->Projects->get((int) $id, contain: []);
		} catch (\Cake\Datasource\Exception\RecordNotFoundException $exeption) {
			$this->Flash->warning(__($exeption->getMessage()), ['plugin' => 'Jeffadmin']);
			return $this->redirect(['action' => 'index']);
		}

		$this->set('title', __('Edit the') . ': ' . __('project') . ' ' . __('record'));
		$this->session->write('Layout.' . $this->controller . '.LastId', $id);
			
		if ($this->request->is(['patch', 'post', 'put'])) {
			$data = $this->request->getData();
			//debug($data);
			$project = $this->Projects->patchEntity($project, $data);
			//dd($project);
			/*
				if(...){
					$project->setError('field', __('Message'));
				}
			*/
			//dd($project->getErrors());
			if (!$project->hasErrors() && $this->Projects->save($project)) {
				//$this->Flash->success(__('The project has been saved.'), ['plugin' => 'Jeffadmin']);
				$this->Flash->success(__('The save has been: OK'), ['plugin' => 'Jeffadmin']);

				//return $this->redirect(['action' => 'index']);
				return $this->redirect([
					'controller' => $this->controller,
					'action' => 'index',
					'#' => $project->id
				]);

			}
			//$this->Flash->error(__('The project could not be saved. Please, try again.'), ['plugin' => 'Jeffadmin']);
			$this->Flash->error(__('The save has been not. Please check the datas and try again.'), ['plugin' => 'Jeffadmin']);
        }
		$name = $project->name;
        $this->set(compact('project', 'id', 'name'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
		$this->request->allowMethod(['post', 'delete']);

		try {
			$project = $this->Projects->get((int) $id);
		} catch (\Cake\Datasource\Exception\RecordNotFoundException $exeption) {
			$this->Flash->warning(__($exeption->getMessage()), ['plugin' => 'Jeffadmin']);
			return $this->redirect(['action' => 'index']);
		}

		if ($this->Projects->delete($project)) {
			$this->session->delete('Layout.' . $this->controller . '.LastId');
			//$this->Flash->success(__('The project has been deleted.'), ['plugin' => 'Jeffadmin']);
			$this->Flash->success(__('The has been deleted.'), ['plugin' => 'Jeffadmin']);
		} else {
			//$this->Flash->error(__('The project could not be deleted. Please, try again.'), ['plugin' => 'Jeffadmin']);
			$this->Flash->error(__('The has been deleted. Please check the datas and try again.'), ['plugin' => 'Jeffadmin']);
		}

        return $this->redirect(['action' => 'index']);
    }
}

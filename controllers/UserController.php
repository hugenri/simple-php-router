<?php


    namespace controllers;
    
    use core\BaseController;
    use models\UserModel;
    
    class UserController extends BaseController
    {
        protected $userModel;
    
        public function __construct()
        {
            parent::__construct(); // Call the constructor of BaseController
            $this->userModel = new UserModel();
        }

        public function index() {
            $this->render('user/index');
        }
        public function show($id)
        {
            // Get user from model
            $user = $this->userModel->find($id);
            
            if (!$user) {
                // User not found - redirect with error message
                $this->redirect->route('/users', 404);
                return;
            }
    
            // Show user details
            $this->view->render('users/show', [
                'user' => $user,
                'title' => 'Detalles del Usuario'
            ]);
        }
    
        public function create()
        {
            // Show create user form
            $this->view->render('users/create', [
                'title' => 'Crear Nuevo Usuario'
            ]);
        }
    
        public function store()
        {
            // Validate form data
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? '',
                'password' => password_hash($_POST['password'] ?? '', PASSWORD_BCRYPT)
            ];
    
            // Create user in the database
            $userId = $this->userModel->create($data);
    
            // Redirect to user details with success message
            $this->redirect->route("/users/{$userId}");
            
            
        }
    
        public function edit($id)
        {
            // Get user for editing
            $user = $this->userModel->find($id);
            
            if (!$user) {
                $this->redirect->route('/users', 404);
                return;
            }
    
            $this->view->render('users/edit', [
                'user' => $user,
                'title' => 'Editar Usuario'
            ]);
        }
    
        public function update($id)
        {
            // Validate form data
            $data = [
                'name' => $_POST['name'] ?? '',
                'email' => $_POST['email'] ?? ''
            ];
    
            // Update user in the database
            $rowsAffected = $this->userModel->update($id, $data);
    
            if ($rowsAffected > 0) {
                $this->redirect->route("/users/{$id}");
            } else {
                // Redirect to edit page with error message
                $this->redirect->route("/users/{$id}/edit");
            }
        }
    
        public function delete($id)
        {
            // Delete user
            $rowsAffected = $this->userModel->delete($id);
    
            if ($rowsAffected > 0) {
                $this->redirect->route('/users');
            } else {
                // Redirect to user details with error message
                $this->redirect->route("/users/{$id}");
            }
        }
    }

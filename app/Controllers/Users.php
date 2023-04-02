<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\User;

class Users extends ResourceController
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $users = $this->user->findAll();
        return $this->respond($users);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $validation = $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            "email" => "required|valid_email|is_unique[users.email]",
            "username" => "required|is_unique[users.username]",
        ]);

        if (!$validation) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $user = [
            'first_name' => $this->request->getVar('first_name'),
            'last_name' => $this->request->getVar('last_name'),
            'email' => $this->request->getVar('email'),
            'username' => $this->request->getVar('username'),
            'admin' => $this->request->getVar('admin')
        ];
        $userId = $this->user->insert($user);

        if ($userId) {
            $user['id'] = $userId;
            return $this->respondCreated($user);
        }
        return $this->fail('Sorry! no user created');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $user = $this->user->find($id);
        if ($user) {

            $validation = $this->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                "email" => "required|valid_email|is_unique[users.email]",
                "username" => "required|is_unique[users.username]",
            ]);

            if (!$validation) {
                return $this->failValidationErrors($this->validator->getErrors());
            }

            $user = [
                'id' => $id,
                'first_name' => $this->request->getVar('first_name'),
                'last_name' => $this->request->getVar('last_name'),
                'email' => $this->request->getVar('email'),
                'username' => $this->request->getVar('username'),
                'admin' => $this->request->getVar('admin')
            ];

            $response = $this->user->save($user);
            if ($response) {
                return $this->respond($user);
            }
            return $this->fail('Sorry! not updated');
        }
        return $this->failNotFound('Sorry! no student found');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $user = $this->user->find($id);
        if ($user) {
            $response = $this->user->delete($id);
            if ($response) {
                return $this->respond($user);
            }
            return $this->fail('Sorry! not deleted');
        }
        return $this->failNotFound('Sorry! no user found');
    }
}

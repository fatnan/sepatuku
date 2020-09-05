<?php namespace App\Controllers;

use CodeIgniter\Controller;

class Form extends Controller
{
    public function index()
    {
        
        $validation =  \Config\Services::validation();
        // $validation->setRule('username', 'Username', 'required');
        $validation->setRules([
            'username' => ['label' => 'Username', 'rules' => 'required'],
            'password' => ['label' => 'Password', 'rules' => 'required|min_length[10]']
        ]);
        $errors = $validation->getErrors();

        // Returns:
        [
            'field1' => 'error message',
            'field2' => 'error message',
        ];
        if ($validation->hasError('username'))
        {
            echo $validation->getError('username');
        }
        helper(['form', 'url']);

        if (! $this->validate([]))
        {
            echo view('auth/signup', [
                'validation' => $this->validator
            ]);
        }
        else
        {
            echo view('Success');
        }
    }
}
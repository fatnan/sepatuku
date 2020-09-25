<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
	public $signup = [
        'username' => [
            'rules'  => 'required',
            'errors' => [
                'required' => 'You must choose a Username.'
            ]
        ],
        'email'    => [
            'rules'  => 'required|valid_email',
            'errors' => [
                'valid_email' => 'Please check the Email field. It does not appear to be valid.'
            ]
        ],
	];
	
	public $register = [
		'username' => [
		 'rules' => 'required|min_length[5]|is_unique[user.username]',
		],
		'name' => [
			'rules' => 'required|min_length[3]'
		],
		'email' => [
			'rules' => 'required|min_length[5]',
		   ],
		'password' => [
		 'rules' => 'required',
		],
		'repeatPassword'=>[
		 'rules' => 'required|matches[password]',
		],
	   ];public $register_errors = [
		'username' => [
		 'required' =>'Username Harus Diisi',
		 'min_length' => 'Username Minimal 5 Karakter',
		],
		'name' => [
			'required' => 'Full Name Harus Diisi',
			'min_length' => 'Full Name minimal 3'
		],
		'email' => [
			'required' =>'Email Harus Diisi'
		],
		'password' => [
		 'required' => 'Password Harus Diisi',
		],
		'repeatPassword'=>[
		 'required' => 'Retype Password Harus Diisi',
		 'matches' => 'Retype Password Tidak Match Dengan Password'
		],
	   ];public $login = [
		'username' => [
		 'rules' => 'required|min_length[5]',
		],
		'password' => [
		 'rules' => 'required',
		],
	   ];public $login_errors = [
		'username' => [
		 'required' =>'{field} Harus Diisi',
		 'min_length' => '{field} Minimal 5 Karakter',
		],
		'password' => [
		 'required' => '{field} Harus Diisi',
		],
	   ];
}

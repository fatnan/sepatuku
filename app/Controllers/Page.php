<?php namespace App\Controllers;

class Page extends BaseController
{
    public function index()
	{
        $data = [
            'title' => 'Home'
        ];

		return view('pages/home',$data);
    }
    
	public function about()
	{
        $data = [
            'title' => 'About'
        ];
		return view('pages/about',$data);
    }
    
    public function contact()
	{
        $data = [
            'title' => 'Contact',
            'alamat' => [
                [
                    'alamat' => 'Jl. kebon bibit no 1',
                    'kota' => 'Bandung',
                    'telp' => '022-1234567'
                ],
                [
                    'alamat' => 'Jl. Taman Sari no 1',
                    'kota' => 'Bandung',
                    'telp' => '022-7654321'
                ],
            ]
        ];
		return view('pages/contact',$data);
	}
	//--------------------------------------------------------------------

}

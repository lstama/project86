<?php

namespace App\Http\Controllers;

use App\SOS;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
		$this->middleware('admin');
	}

	public function sos_index()
	{
		$sos = SOS::latest()->paginate(15);
		return view('sos_index', ['sos' => $sos]);
	}
}

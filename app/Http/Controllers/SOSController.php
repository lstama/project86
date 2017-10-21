<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;
use App\SOS;
use App\User;

class SOSController extends Controller
{
	private $email;
	private $hashed_password;
	private $latitude;
	private $longitude;

	public function handleSOSRequest(Request $request)
	{
		try {
			$this->email = $request->input('email');
			$this->hashed_password = $request->input('hashed_password');
			$this->latitude = $request->input('latitude');
			$this->longitude = $request->input('longitude');
		}
		catch(Exception $e) {
			return;
		}


		if ($this->isAuthorizedRequest()) {
			if ($this->isValidLocation()) {
				$this->saveSOS();
			}
		}
	}

	private function isAuthorizedRequest() {
		#$user = DB::table('users')->where('email', $this->email)->first();
		$user = User::where('email', $this->email)->first();
		try {
			if ($user->hashed_password == $this->hashed_password) {
				return true;
			}
		}
		catch (Exception $e) {
			return false;
		}
		return false;
	}

	private function isValidLocation() {
		$latitude_result = preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $this->latitude);
		$longitude_result = preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $this->longitude);
		if ($latitude_result == 1 && $longitude_result == 1) {
			return true;
		}
		return false;
	}

	private function saveSOS() {
		try {
//			DB::table('SOS')->insert(
//				[
//					'email' => $this->email,
//					'latitude' => $this->latitude,
//					'longitude' => $this->longitude,
//					//'created_at' =>
//				]
//			);

			$sos = new SOS;
			$sos->email = $this->email;
			$sos->latitude = $this->latitude;
			$sos->longitude = $this->longitude;
			$sos->save();

		}
		catch (Exception $e) {
			return;
		}

	}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;
# use Illuminate\Support\Facades\DB;
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
		$this->getRequest($request);
		$user = User::where('email', $this->email)->first();
		http_response_code(200);
		if ($this->isAuthorizedRequest($user)) {
			if ($this->isValidLocation()) {
				$this->saveSOS();
				return;
			}
		}
		echo 0;
	}

	public function checkLoginMobileRequest(Request $request)
	{
		$this->getRequest($request);
		$user = User::where('email', $this->email)->first();
		http_response_code(200);
		header('Content-Type: application/json');


		if ($this->isAuthorizedRequest($user)) {
			$fullname = $user->name;
			$data = [
				"status" => "1",
				"fullname" =>$fullname,
			];
			echo json_encode($data);
		}
		else {
			$data = [
				"status" => "1",
			];
			echo json_encode($data);
		}
	}

	public function getRequest(Request $request)
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
	}

	private function isAuthorizedRequest($user)
	{
		#$user = DB::table('users')->where('email', $this->email)->first();

		try {
			if (is_null($user)) return false;
			if ($user->hashed_password == $this->hashed_password) {
				return true;
			}
		}
		catch (Exception $e) {
			return false;
		}
		return false;
	}

	private function isValidLocation()
	{
		if (is_numeric($this->latitude) && is_numeric($this->longitude)) {
			if ($this->latitude >= -90 && $this->latitude <= 90) {
				if ($this->longitude >= -180 && $this->longitude <= 180) {
					return true;
				}
			}
		}

		return false;
	}

	private function saveSOS()
	{
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
			echo 0;
			return;
		}

		echo 1;

	}

}

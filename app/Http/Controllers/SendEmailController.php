<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;

class SendEmailController extends Controller
{
	function index()
	{
		return view('send_email');
	}
	function send(Request $request)
	{
		$this->validate($request, [
			'name' => 'required',
			'email' => 'required|email',
			'message' => 'required'
		]);
		$data = array(
			'name' => $request->name,
			'email' => $request->email,
			'message' => $request->message,
			'time' => \Carbon::now('Asia/Ho_Chi_Minh')->toDayDateTimeString()
		);

		//Thiết lập thông tin SĐT người nhận

		$basic  = new \Nexmo\Client\Credentials\Basic('f563b253', 'CcQPrwud7WvTYRcI');
		$client = new \Nexmo\Client($basic);
		$message = $client->message()->send([
			'to' => '84971130703',
			'from' => 'Nexmo',
			'text' => $request->message
		]);

    	//Thiết lập thông tin Email người nhận

		$email = new SendMail($data);
		Mail::to('gnoht1111@gmail.com')->send($email);
		return back()->with('success', 'Thanks for contacting us!');
	}
}

<?php

namespace App\Http\Controllers;
use App\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email|unique:subscribers'
        ],[

        	'email.require'  => 'Email không được để trống',
            'email.unique'  => 'Email này đã đăng ký, chọn email khác',
            'email.email'	=> 'Vui lòng kiểm tra định dạng email'
        ]);


        	$subscriber = new Subscriber();
        	$subscriber->email = $request->email;
       		 $subscriber->save();
        	\Session::flash('toastr',[
        	'type' => 'success',
        	'message' => 'Bạn đã đặt mua báo thành công'
        ]);

        return redirect()->back();
    }
}

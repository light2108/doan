<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendMail;
class AdminController extends Controller
{
  public function Login(Request $request)
  {
    // dd(Hash::make(1));

    if ($request->isMethod('post')) {
      $data = $request->all();
      if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {
        // Admin::where('id', Auth::guard('admin')->user()->id)->update(['status'=>1]);
        return redirect('/admin/dashboard')->with('success_message', 'Welcome back admin');
      } else {
        return redirect()->back()->with('error_message', 'Your email or password incorrect or user not active');
      }
    }
    return View('admin.login');
  }
  public function Index()
  {
    $admin = Admin::where('id', Auth::guard('admin')->user()->id)->where('status', 1)->first()->toArray();
    // dd($admin['name']);
    Session::put('page', 'admin_setting');
    Session::put('name', $admin['name']);
    Session::put('subject', $admin['subject_id']);
    return View('admin.index');
  }
  public function Logout()
  {
    // Admin::where('id', Auth::guard('admin')->user()->id)->update(['status'=>0]);
    Auth::guard('admin')->logout();

    return redirect('/admin');
  }
  public function changeDetail(Request $request)
  {
    Session::put('page', 'admin_detail');

    $admindetails = Admin::where('id', Auth::guard('admin')->user()->id)->where('status', 1)->first();
    if ($request->isMethod('post')) {
      $data = $request->all();
      if ($request->hasFile('image')) {
        $image = $request->file('image');
        $reimage = 'imgs/' . time() . '.' . $image->getClientOriginalExtension();
        $dest = public_path('/imgs');
        $image->move($dest, $reimage);
        Admin::where('id', Auth::guard('admin')->user()->id)->update(['mobile' => $data['mobile'], 'image' => $reimage, 'email' => $data['email'], 'status' => (($data['status'] == 1) ? 1 : 0), 'name' => $data['name']]);
        return redirect()->back()->with('success_message', 'Your profile has been updated successfully');
      } else {
        Admin::where('id', Auth::guard('admin')->user()->id)->update(['mobile' => $data['mobile'], 'image' => $admindetails->image, 'email' => $data['email'], 'status' => (($data['status'] == 1) ? 1 : 0), 'name' => $data['name']]);
        return redirect()->back()->with('success_message', 'Your profile has been updated successfully');
      }
      Admin::where('id', Auth::guard('admin')->user()->id)->update($data);
    }
    return View('admin.change_detail', compact('admindetails'));
  }
  public function changePassword(Request $request)
  {
    Session::put('page', 'admin_password');
    // dd(Hash::make(1));
    $admindetails = Admin::where('id', Auth::guard('admin')->user()->id)->where('status', 1)->first();
    // dd($admindetails[0]);
    if ($request->isMethod('post')) {
      $data = $request->all();
      if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
        if ($data['new_password'] == $data['confirm_password']) {
          Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => Hash::make($data['new_password'])]);
          return redirect()->back()->with('success_message', 'Changed password successfully');
        } else {
          return redirect()->back()->with('error_message', 'New password and confirm password not same');
        }
      }
    }
    return View('admin.change_password', compact('admindetails'));
  }
  public function checkUpdatePassword(Request $request)
  {
    if ($request->ajax()) {
      $data = $request->all();
      // dd($data);
      if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
        return response()->json(['status' => true]);
      } else return response()->json(['status' => false]);
    }
  }
  // public function sendEmail($user, $code)
  // {
  //   Mail::send(
  //     'admin.confirm-code',
  //     ['user' => $user, 'code' => $code],
  //     function ($message) use ($user) {
  //       $message->to($user->email);
  //       $message->subject("$user->name, reset your password");
  //     }
  //   );
  // }
  public function forgotPassword(Request $request)
  {
    if ($request->isMethod('post')) {
      $data = $request->all();
      $user = Admin::where('email', $data['email'])->where('status', 1)->first();
      if (empty($user)) {
        return redirect()->back()->with('error_message', 'Email not exists');
      } else {
        $mail_details = [
            'name'=>$user['name'],
            'email' => $data['email'],
            'code'=>Str::random(64)
          ];
        Mail::to($data['email'])->send(new SendMail($mail_details));
        // $this->sendEmail($user, Str::random(64));
        return redirect()->back()->with('success_message', 'Send code successfully');
      }
    }
    return View('admin.forgot-password');
  }
  public function resetPassword(Request $request, $email, $code)
  {
    if ($request->isMethod('post')) {
      $data = $request->all();
      if ($data['email'] == $email && $data['password'] == $data['confirm_password']) {
        Admin::where('email', $email)->first()->update(['password' => Hash::make($data['password'])]);
        return redirect('/admin')->with('success_message', 'Change password successfully');
      }
    }
    return View('admin.reset-password', compact('code', 'email'));
  }
}

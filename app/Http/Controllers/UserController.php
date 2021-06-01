<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\User;

class UserController extends Controller
{
     public function index()
     {
        $data['users'] = User::orderBy('id','DESC')->get();
        return view('backend.users.view',$data);
    }
    
    public function create()
    {
         return view('backend.users.add');
    }

    
    public function store(Request $request)
    {

        $validators =  Validator::make($request->all(),[
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'mobile' => 'required|numeric|unique:users',
                'password' => 'required',
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $user = New User();
             $user->name    = $request->name;
             $user->email   = $request->email;
             $user->mobile  = $request->mobile;
             $user->password= bcrypt($request->password);
             $user->role    = 1;
             $user->type    = 1;



            $image = $request->file('photo');
            if($image){
                $uniqname = uniqid();
                $ext = strtolower($image->getClientOriginalExtension());
                $filepath = 'public/images/users/';
                $imagename = $filepath.$uniqname.'.'.$ext;
                $image->move($filepath,$imagename);
                $user->image = $imagename;
            }


             $user->status  = 1;
             $user->save();

            $notification = array(
                    'message' => 'Successfully User added!',
                    'alert-type' => 'success'
            );

            return redirect()->route('user.index')->with($notification);

         }



    }

   
    public function show(Size $size)
    {
        //
    }

    
    public function edit(User $user,$id)
    {
        $data['user'] = User::find($id);
        return view('backend.users.edit',$data);
    }

    
    public function update(Request $request, User $user,$id)
    {
          $validators =  Validator::make($request->all(),[
               'name' => 'required',
                'email' => 'required|email|unique:users,email,'.$id,
                'mobile' => 'required|numeric|unique:users,mobile,'.$id,
        ]);

        if($validators->fails()){
                $notification = array(
                    'message' => 'Someting Error!',
                    'alert-type' => 'error'
                );

                return redirect()->back()->withErrors($validators)->withInput();
        }

        else{

             $user =  User::find($id);
             $user->name    = $request->name;
             $user->email   = $request->email;
             $user->mobile  = $request->mobile;
             if($request->password)
             {
                $user->password= bcrypt($request->password);
             }

            $image = $request->file('photo');
            if($image){
                $uniqname = uniqid();
                $ext = strtolower($image->getClientOriginalExtension());
                $filepath = 'public/images/users/';
                $imagename = $filepath.$uniqname.'.'.$ext;
                $image->move($filepath,$imagename);
                $user->image = $imagename;
            }


            $user->save();

            $notification = array(
                    'message' => 'Successfully User Updated!',
                    'alert-type' => 'success'
            );

            return redirect()->route('user.index')->with($notification);

         }

    }

    public function destroy(Size $size)
    {
         User::find($id)->delete();

         $notification = array(
                    'message' => 'Successfully User deleted!',
                    'alert-type' => 'success'
            );

        return redirect()->route('user.index')->with($notification);

    }   

}
<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'id');
        $user_filter = '%' . $request->input('user') . '%';
        $users = User::orderBy('name', 'asc')
//            ->where('name', 'like', $user_name)
            ->where(function ($query) use ($user_filter, $sort) {
                $query->where('email', 'like', $user_filter)
                    ->orderBy($sort);
            })
            ->orWhere(function ($query) use ($user_filter, $sort) {
                $query->where('name', 'like', $user_filter)
                    ->orderBy($sort);
            })
            ->paginate(10)
            ->appends(['name' => $request->input('name')]);

        $result = compact('users');
        Json::dump($result);
        return view('admin.users.index', $result);
//        $users = User::where('name', 'like', $user_filter)
//            ->orderBy($request->input('sort', 'id'))
//            ->paginate(10);
//        $result = compact('users');
//        Json::dump($result);

        //naar view met data
//        return view('admin.users.index', $result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $result = compact('user');
        Json::dump($result);
        return view('admin.users.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'active' => 'required',
            'admin' => 'required'

        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->active = $request->has('active');
        $user->admin = $request->has('admin');
        $user->save();
        session()->flash('success', 'The user has been updated');
        return redirect("/admin/users");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (auth()->user()->name == $user->name) {
            return response()->json([
                'type' => 'error',
                'text' => 'In order not to exclude yourself from (the admin section of) the application, you cannot delete your own profile']);
            return back();

        } else {
            $user->delete();
            return response()->json([
                'type' => 'success',
                'text' => "The user <b>$user->name</b> has been deleted"
            ]);
        }
    }

    public function qryUsers()
    {
        $users = User::orderBy('name')
            ->get();
        return $users;
    }
}

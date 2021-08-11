<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(100);
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }
    public function update(Request $request, User $user) {
        $data = $this->validate($request,
            [
                'name' => 'string|max:255',
                'surname' => 'string|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,  //$user->id - чтобы не было проблем с unique
            ]);
        if (!empty($request['password'])) {
            $this->validate($request, [
                'password' => 'required|string|min:6',
            ]);
            $data['password'] = bcrypt($request['password']);
        }
        $user->update($data);
        $users = User::latest()->paginate(100);
        return redirect()->route('admin.users.index', compact('users'));
    }
    public function store(Request $request)
    {
        //dd($request);
        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'email|unique:users',
        ]);
        $data['password'] = bcrypt($request['password']);
        $user = User::create($data);

        $users = User::latest()->paginate(100);
        return redirect()->route('admin.users.index', compact('users'));
    }
    public function destroy(User $user) {
        $user->delete();
        return redirect('/admin/users/index');
    }
}

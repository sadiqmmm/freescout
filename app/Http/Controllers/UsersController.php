<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Validation\Rule;
use App\User;
use App\Mailbox;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Users list
     */
    public function users()
    {
        $users = User::all();

        return view('users/users', ['users' => $users]);
    }

    /**
     * New user
     */
    public function create()
    {
        $this->authorize('create', 'App\User');
        $mailboxes = Mailbox::all();

        return view('users/create', ['mailboxes' => $mailboxes]);
    }

    /**
     * Create new mailbox
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function createSave(Request $request)
    {
        $this->authorize('create', 'App\User');

        $rules = [
            'role' => 'integer',
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:30',
            'email' => 'required|string|email|max:100|unique:users',
            'role' => [ 'required', Rule::in(User::$roles)]
        ];
        if (empty($request->send_invite)) {
            $rules['password'] = 'required|string|max:255';
        }
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('users.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $user = new User;
        $user->fill($request->all());

        if (!empty($request->send_invite)) {
            $password = $user->generatePassword();
        }

        $user->save();

        $user->mailboxes()->sync($request->mailboxes);
        $user->syncPersonalFolders($request->mailboxes);

        // Send invite
        if (!empty($request->send_invite)) {
            // todo
        }

        \Session::flash('flash_success', __('User created successfully'));
        return redirect()->route('users.profile', ['id' => $user->id]);
    }

    /**
     * User profile
     */
    public function profile($id)
    {
        $user = User::findOrFail($id);

        $this->authorize('view', $user);

        $users = User::all()->except($id);

        return view('users/profile', ['user' => $user, 'users' => $users]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function profileSave($id, Request $request)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:20',
            'last_name' => 'required|string|max:30',
            'email' => 'required|string|email|max:100|unique:users,email,'.$id,
            'emails' => 'max:100',
            'job_title' => 'max:100',
            'phone' => 'max:60',
            'timezone' => 'required|string|max:255',
            'time_format' => 'required',
            'role' => [ 'required', Rule::in(User::$roles)]
        ]);

        //event(new Registered($user = $this->create($request->all())));

        if ($validator->fails()) {
            return redirect()->route('users.profile', ['id' => $id])
                        ->withErrors($validator)
                        ->withInput();
        }

        $user->fill($request->all());

        if (empty($request->input('enable_kb_shortcuts'))) {
            $user->enable_kb_shortcuts = false;
        }

        $user->save();

        \Session::flash('flash_success', __('Profile saved successfully'));
        return redirect()->route('users.profile', ['id' => $id]);
    }

    /**
     * User mailboxes
     */
    public function permissions($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $mailboxes = Mailbox::all();

        return view('users/permissions', ['user' => $user, 'mailboxes' => $mailboxes, 'user_mailboxes' => $user->mailboxes]);
    }

    /**
     * Save user permissions
     * 
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     */
    public function permissionsSave($id, Request $request)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $user->mailboxes()->sync($request->mailboxes);
        $user->syncPersonalFolders($request->mailboxes);

        \Session::flash('flash_success', __('Permissions saved successfully'));
        return redirect()->route('users.permissions', ['id' => $id]);
    }
}

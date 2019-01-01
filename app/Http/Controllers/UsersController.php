<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use DB;
use App\User;
use Illuminate\Http\Request;
use League\Csv\Writer;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function disableUser($id){
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try {
            $userData = [
                'role'   => 0,
            ];
            $user->update($userData);
            DB::commit();
            return redirect('users')->with('flash_message', 'User disabled!');
        } catch (\Exception $e) {
            DB::rollback();
            die($e->getMessage());
            return false;
        }

    }

    public function enableUser($id){
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try {
            $userData = [
                'role'   => 2,
            ];
            $user->update($userData);
            DB::commit();
            return redirect('users')->with('flash_message', 'User enabled!');
        } catch (\Exception $e) {
            DB::rollback();
            die($e->getMessage());
            return false;
        }

    }

    public function exportCSV(){
        $user = \App\User::withTrashed()->get();
        $csv = \League\Csv\Writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(\Schema::getColumnListing('users'));
        foreach ($user as $export) {
            $csv->insertOne($export->toArray());
        }

        $csv->output('users.csv');
        die;
    }

    public function index(Request $request)
    {
        $keyword = $request->get('table_search');
        $perPage = 25;

        if (!empty($keyword)) {
            $users = User::where('firstname', 'LIKE', "%$keyword%")
                ->orWhere('lastname', 'LIKE', "%$keyword%")
                ->orWhere('email', 'LIKE', "%$keyword%")
                ->orWhere('role', 'LIKE', "%$keyword%")
                ->paginate($perPage);
        } else {
            $users = User::paginate($perPage);
        }

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstname'        => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:users',
            'password'         => 'required|min:6',
            'confirm_password' => 'required_with:password|same:password'
        ]);


        DB::beginTransaction();
        try {
            User::create( [
                'firstname' => $request['firstname'],
                'lastname' => $request['lastname'],
                'email'  => $request['email'],
                'role' => $request['role'],
                'password'  => bcrypt( $request['password'] ),
                'remember_token' => null,
            ] );
            DB::commit();
            return redirect('users')->with('flash_message', 'User added!');
        } catch (\Exception $e) {
            DB::rollback();
            die($e->getMessage());
            return false;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        
        $requestData = $request->all();
        
        $user = User::findOrFail($id);
        $user->update($requestData);

        return redirect('users')->with('flash_message', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('users')->with('flash_message', 'User deleted!');
    }

    public function restore($id)
    {
        \App\User::withTrashed()->where('id', $id)->restore();
        return redirect('users')->with('flash_message', 'User restored!');
    }
}

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('tasks',[
        'tasks' =>  \App\Task::orderBy('created_at', 'asc')->get()
    ]);
});

/**
 * Add A New Task
 */
Route::post('/task', function (\Illuminate\Http\Request $request) {
    $validator = Validator::make($request->all(), [
        'name' => 'required|max:255',
    ]);

    if ($validator->fails()) {
        return redirect('/')
            ->withInput()
            ->withErrors($validator);
    }

    $task = new \App\Task();
    $task->name = $request->name;
    $task->save();

    return redirect('/');
});


/**
 * Delete An Existing Task
 */
Route::delete('/task/{id}', function ($id) {

    \App\Task::findOrFail($id)->delete();
    return redirect('/');
});
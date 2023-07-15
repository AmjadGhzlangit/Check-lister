<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request , Checklist $checklist)
    {
        $checklist->tasks()->create($request->validated());
        return redirect()
        ->route('admin.checklist_group.checklist.edit',[ $checklist->checklist_group_id,$checklist])
        ->with('task_added','Task Added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklist , Task $task)
    {
        return view('admin.tasks.edit',compact('checklist','task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreTaskRequest $request , Checklist $checklist ,Task $task)
    {
       $task->update($request->validated());
        return redirect()
        ->route('admin.checklist_group.checklist.edit',[ $checklist->checklist_group_id,$checklist])
        ->with('task_updated','Task has been updated successfully'); ;
      
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklist , Task $task)
    {
        $task->delete();
        return redirect()
        ->route('admin.checklist_group.checklist.edit',[ $checklist->checklist_group_id,$checklist])
        ->with('task_delete','Task Deleted successfully');
    }
}

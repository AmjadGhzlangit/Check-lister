<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   
    public function index()
    {
        //
    }

   
    public function create()
    {
        //
    }

   
    public function store(StoreTaskRequest $request , Checklist $checklist):RedirectResponse
    {
        $checklist->tasks()->create($request->validated());
        return redirect()
        ->route('admin.checklist_group.checklist.edit',[ $checklist->checklist_group_id,$checklist])
        ->with('task_added','Task Added successfully');
    }

   
    public function show(string $id)
    {
        //
    }

   
    public function edit(Checklist $checklist , Task $task):View
    {
        return view('admin.tasks.edit',compact('checklist','task'));
    }

    
    public function update(StoreTaskRequest $request , Checklist $checklist ,Task $task):RedirectResponse
    {
       $task->update($request->validated());
        return redirect()
        ->route('admin.checklist_group.checklist.edit',[ $checklist->checklist_group_id,$checklist])
        ->with('task_updated','Task has been updated successfully'); ;
      
    }

    
    public function destroy(Checklist $checklist , Task $task):RedirectResponse
    {
        $task->delete();
        return redirect()
        ->route('admin.checklist_group.checklist.edit',[ $checklist->checklist_group_id,$checklist])
        ->with('task_delete','Task Deleted successfully');
    }
}

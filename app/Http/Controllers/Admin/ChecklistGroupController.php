<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListGroupRequest;
use App\Models\ChecklistGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ChecklistGroupController extends Controller
{
   
    public function create():View
    {
        return view('admin.checklist-group.create',);
    }


    public function store(StoreCheckListGroupRequest $request):RedirectResponse
    {
        $checklistgroups = ChecklistGroup::create($request->validated());

        return redirect()->route('dashboard');
    }
   
    public function edit(ChecklistGroup $checklist_group):View
    {
        
         return view('admin.checklist-group.edit',compact('checklist_group'));
    }

   
    public function update(StoreCheckListGroupRequest $request,ChecklistGroup $checklist_group):RedirectResponse
    {
        $checklist_group->update($request->validated());

        return redirect()->route('dashboard');
    }

   
    public function destroy(ChecklistGroup $checklist_group):RedirectResponse
    {
        $checklist_group->delete();

        return redirect()->route('dashboard');
    }
}

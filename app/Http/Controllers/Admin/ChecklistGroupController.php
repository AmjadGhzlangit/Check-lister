<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCheckListGroupRequest;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use Illuminate\Http\Request;

class ChecklistGroupController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.checklist-group.create',);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCheckListGroupRequest $request,)
    {
        $checklistgroups = ChecklistGroup::create($request->validated());

        return redirect()->route('dashboard');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChecklistGroup $checklist_group)
    {
        
         return view('admin.checklist-group.edit',compact('checklist_group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCheckListGroupRequest $request,ChecklistGroup $checklist_group)
    {
        $checklist_group->update($request->validated());

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChecklistGroup $checklist_group)
    {
        $checklist_group->delete();

        return redirect()->route('dashboard');
    }
}

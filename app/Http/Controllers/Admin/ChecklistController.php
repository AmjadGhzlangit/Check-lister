<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistRequest;
use App\Http\Requests\StoreCheckListGroupRequest;
use App\Models\Checklist;
use App\Models\ChecklistGroup;

class ChecklistController extends Controller
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
    public function create(ChecklistGroup $checklist_group)
    {
        return view('admin.checklist.checklist-create',compact('checklist_group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCheckListGroupRequest $request,ChecklistGroup $checklist_group)
    {
        $checklist_group->checklist()->create($request->validated());
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(ChecklistGroup $checklist_group)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ChecklistGroup $checklist_group , Checklist $checklist)
    {
        return view('admin.checklist.checklist-edit',compact('checklist_group','checklist'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ChecklistRequest $request,ChecklistGroup $checklist_group, Checklist $checklist)
    {
        $checklist->update($request->validated());

        return redirect()->route('dashboard')->with('success','Checklist updated successfully');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ChecklistGroup $checklist_group,Checklist $checklist)
    {
        $checklist->delete();
        return redirect()->route('dashboard');

    }
}

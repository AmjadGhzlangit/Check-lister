<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChecklistRequest;
use App\Http\Requests\StoreCheckListGroupRequest;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ChecklistController extends Controller
{
    public function create(ChecklistGroup $checklist_group) : View
    {
        return view('admin.checklist.checklist-create',compact('checklist_group'));
    }

    public function store(StoreCheckListGroupRequest $request,ChecklistGroup $checklist_group): RedirectResponse
    {
        $checklist_group->checklist()->create($request->validated());
        return redirect()->route('dashboard');
    }

    public function edit(ChecklistGroup $checklist_group , Checklist $checklist):View
    {
        return view('admin.checklist.checklist-edit',compact('checklist_group','checklist'));
    }

    
    public function update(ChecklistRequest $request,ChecklistGroup $checklist_group, Checklist $checklist):RedirectResponse
    {
        $checklist->update($request->validated());

        return redirect()->route('dashboard')->with('success','Checklist updated successfully');;
    }


    public function destroy(ChecklistGroup $checklist_group,Checklist $checklist):RedirectResponse
    {
        $checklist->delete();
        return redirect()->route('dashboard');

    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCheckListRequest;
use App\Models\Checklist;
use App\Models\ChecklistGroup;
use Illuminate\Http\RedirectResponse;
use  Illuminate\Contracts\View\View;

class ChecklistController extends Controller
{


    public function create(ChecklistGroup $checklistGroup): view
    {
        return view('admin.checklists.create', compact('checklistGroup'));
    }

    public function store(CreatechecklistRequest $request, ChecklistGroup $checklistGroup): RedirectResponse
    {
        $checklistGroup->checklists()->create($request->validated());

        return redirect()->route('welcome');
    }


    public function edit(ChecklistGroup $checklistGroup, Checklist $checklist): view
    {
        return view('admin.checklists.edit', compact('checklistGroup', 'checklist'));
    }


    public function update(CreateChecklistRequest $request, ChecklistGroup $checklistGroup, Checklist $checklist): RedirectResponse
    {
        $checklist->update($request->validated());

        return redirect()->route('welcome');
    }


    public function destroy(ChecklistGroup $checklistGroup, Checklist $checklist) :RedirectResponse
    {
        $checklist->delete();
        return redirect()->route('welcome');
    }
}

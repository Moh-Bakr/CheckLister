<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CreateTasksRequest;
use App\Models\Checklist;
use App\Models\Task;
use  Illuminate\Contracts\View\View;

class TaskController extends Controller
{


    public function store(CreateTasksRequest $request, Checklist $checklist): RedirectResponse
    {
        $position = $checklist->tasks()->max('position') + 1;
        $checklist->tasks()->create($request->validated() + ['position' => $position]);
        return redirect()->route('admin.checklist_groups.checklists.edit', [
            $checklist->checklist_group_id, $checklist
        ]);
    }


    public function edit(Checklist $checklist, Task $task): view
    {
        return view('admin.tasks.edit', compact('checklist', 'task'));
    }

    public function update(Checklist $checklist, CreateTasksRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());
        return redirect()->route('admin.checklist_groups.checklists.edit', [
            $checklist->checklist_group_id, $checklist
        ]);
    }


    public function destroy(Checklist $checklist, Task $task): RedirectResponse
    {
        $checklist->tasks()->where('position', '>', $task->position)->update(
            ['position' => \DB::raw('position - 1')]
        );
        $task->delete();

        return redirect()->route('admin.checklist_groups.checklists.edit', [
            $checklist->checklist_group_id, $checklist
        ]);
    }
}

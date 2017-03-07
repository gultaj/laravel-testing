<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\StoreTaskRequest;
use App\Task;
use Illuminate\Http\Request;

class TasksController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTaskRequest|Request $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request, Group $group)
    {
        $this->authorize('affect', $group);

        $group->tasks()->create([
            'body' => $request->body
        ]);

        return redirect()->back()->withSuccess('Task created successfully');
    }

    public function toggle(Request $request, Group $group, Task $task)
    {
        $this->authorize('change', $task);

        $task->update([
            'completed' => !$task->completed
        ]);

        $status = $task->completed ? '' : 'not ';

        return redirect()->back()->withSuccess('Task marked as ' . $status . 'completed');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Group $group, Task $task)
    {
        $this->authorize('change', $task);

        return view('tasks.edit', [
            'task' => $task
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTaskRequest $request, Group $group, Task $task)
    {
        $this->authorize('change', $task);

        $task->update([
            'body' => $request->body
        ]);

        return redirect()->route('groups.show', $group)->withSuccess('Task was updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param Group $group
     * @param Task $task
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Request $request, Group $group, Task $task)
    {
        $this->authorize('change', $task);

        $task->delete();

        return redirect()->back()->withSuccess('Task deleted successfully');
    }
}

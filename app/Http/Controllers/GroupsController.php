<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\StoreGroupRequest;
use Illuminate\Http\Request;

class GroupsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreGroupRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGroupRequest $request)
    {
        $request->user()->groups()->create([
            'title' => $request->title
        ]);

        return redirect()->back()->withSuccess('Group created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Group $group
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Request $request, Group $group)
    {
        $this->authorize('show', $group);

        $group->load('tasks');

        return view('groups.show', [
            'group' => $group
        ]);
    }

}

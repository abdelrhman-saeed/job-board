<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Http\Requests\JobPostRequest;


class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return JobPost::filter(request()->only(['title', 'location', 'is_remote', 'description']))
            ->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobPostRequest $request)
    {
        /**
         * @var \App\Models\Company
         */
        $user = $request->user();

        return response()->json([
            'message'   => 'job post created',
            'job_post'  => $user->jobPosts()->create($request->validated())
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return JobPost::where(['id'=> $id, 'company_id' => request()->user()->id])->firstOrFail();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobPostRequest $request, int $id)
    {

        /**
         * @var \App\Models\Company
         */
        $user = $request->user();

        $user->jobPosts()   
                ->where('id', $id)
                ->update($request->validated());

        return response()->json(['mesasge' => 'job post updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        if (JobPost::where(['id'=> $id, 'company_id' => request()->user()->id])->delete()) {

            return response()
                    ->json(['message' => 'job is deleted succussfully'], 410);
        }

        return response()->json(['message' => 'job is deleted succussfully'], 500);
    }
}

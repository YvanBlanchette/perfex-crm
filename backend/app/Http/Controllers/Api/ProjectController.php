<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller {
    public function index(Request $request): JsonResponse {
        $q = Project::with('client')->withCount('tasks');
        if($request->search) $q->where('name','like','%'.$request->search.'%');
        if($request->status) $q->where('status',$request->status);
        if($request->client_id) $q->where('client_id',$request->client_id);
        return response()->json($q->latest()->paginate($request->per_page??15));
    }
    public function store(Request $request): JsonResponse {
        $data = $request->validate(['client_id'=>'required|exists:clients,id','name'=>'required|string','description'=>'nullable|string','status'=>'in:not_started,in_progress,on_hold,cancelled,finished','priority'=>'in:low,medium,high,urgent','start_date'=>'nullable|date','deadline'=>'nullable|date','budget'=>'nullable|numeric','billing_type'=>'in:not_billable,fixed_cost,project_hours,task_hours','rate_per_hour'=>'nullable|numeric','progress'=>'nullable|integer|min:0|max:100']);
        return response()->json(Project::create($data)->load('client'),201);
    }
    public function show(Project $project): JsonResponse { return response()->json($project->load(['client','members','tasks'])->loadCount('tasks')); }
    public function update(Request $request, Project $project): JsonResponse { $project->update($request->all()); return response()->json($project->load('client')); }
    public function destroy(Project $project): JsonResponse { $project->delete(); return response()->json(null,204); }
    public function tasks(Project $project): JsonResponse { return response()->json($project->tasks()->with('assignee')->latest()->get()); }
    public function addMember(Request $request, Project $project): JsonResponse {
        $project->members()->syncWithoutDetaching([$request->user_id]);
        return response()->json(['message'=>'Member added.']);
    }
    public function removeMember(Project $project, int $user): JsonResponse {
        $project->members()->detach($user);
        return response()->json(['message'=>'Member removed.']);
    }
}
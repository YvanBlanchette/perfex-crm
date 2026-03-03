<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\{Task,TaskTimer};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller {
    public function index(Request $request): JsonResponse {
        $q = Task::with(['project','assignee']);
        if($request->project_id) $q->where('project_id',$request->project_id);
        if($request->status) $q->where('status',$request->status);
        if($request->assigned_to) $q->where('assigned_to',$request->assigned_to);
        return response()->json($q->latest()->paginate($request->per_page??20));
    }
    public function store(Request $request): JsonResponse {
        $data = $request->validate(['project_id'=>'required|exists:projects,id','name'=>'required|string','description'=>'nullable|string','status'=>'in:not_started,in_progress,awaiting_feedback,testing,complete','priority'=>'in:low,medium,high,urgent','start_date'=>'nullable|date','due_date'=>'nullable|date','estimated_hours'=>'nullable|numeric','assigned_to'=>'nullable|exists:users,id']);
        $data['created_by'] = auth()->id();
        return response()->json(Task::create($data)->load(['project','assignee']),201);
    }
    public function show(Task $task): JsonResponse { return response()->json($task->load(['project','assignee','timers.user'])); }
    public function update(Request $request, Task $task): JsonResponse { $task->update($request->all()); return response()->json($task->load(['project','assignee'])); }
    public function destroy(Task $task): JsonResponse { $task->delete(); return response()->json(null,204); }
    public function updateStatus(Request $request, Task $task): JsonResponse {
        $task->update(['status'=>$request->validate(['status'=>'required|in:not_started,in_progress,awaiting_feedback,testing,complete'])['status']]);
        return response()->json($task);
    }
    public function startTimer(Task $task): JsonResponse {
        TaskTimer::where('task_id',$task->id)->where('user_id',auth()->id())->whereNull('ended_at')->update(['ended_at'=>now()]);
        $timer = TaskTimer::create(['task_id'=>$task->id,'user_id'=>auth()->id(),'started_at'=>now()]);
        return response()->json($timer,201);
    }
    public function stopTimer(Task $task): JsonResponse {
        $timer = TaskTimer::where('task_id',$task->id)->where('user_id',auth()->id())->whereNull('ended_at')->latest()->first();
        if($timer) $timer->update(['ended_at'=>now()]);
        return response()->json($timer);
    }
}
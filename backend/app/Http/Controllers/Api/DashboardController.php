<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\{Client,Project,Invoice,Lead,Expense,Task};
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller {
    public function index(): JsonResponse {
        return response()->json([
            'stats' => [
                'total_clients'  => Client::count(),
                'active_projects'=> Project::whereIn('status',['in_progress','not_started'])->count(),
                'open_invoices'  => Invoice::whereIn('status',['unpaid','overdue','partial'])->count(),
                'total_revenue'  => Invoice::where('status','paid')->sum('total'),
                'overdue_invoices'=> Invoice::where('status','overdue')->count(),
                'new_leads'      => Lead::where('status','new')->count(),
                'open_tasks'     => Task::whereNotIn('status',['complete'])->count(),
                'monthly_expenses'=> Expense::whereMonth('date',now()->month)->sum('amount'),
            ],
            'recent_invoices' => Invoice::with('client')->latest()->limit(5)->get(),
            'recent_leads'    => Lead::with('assignee')->latest()->limit(5)->get(),
            'recent_projects' => Project::with('client')->latest()->limit(5)->get(),
        ]);
    }
    public function revenueChart(): JsonResponse {
        $data = Invoice::where('status','paid')
            ->where('date','>=',now()->subMonths(11)->startOfMonth())
            ->select(DB::raw('YEAR(date) as year'), DB::raw('MONTH(date) as month'), DB::raw('SUM(total) as total'))
            ->groupBy('year','month')->orderBy('year')->orderBy('month')->get();
        return response()->json($data);
    }
}
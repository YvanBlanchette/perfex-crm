<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller {
    public function index(Request $request): JsonResponse {
        $q = Client::withCount(['projects','invoices']);
        if($request->search) $q->where('company_name','like','%'.$request->search.'%')->orWhere('email','like','%'.$request->search.'%');
        if($request->status) $q->where('status',$request->status);
        return response()->json($q->latest()->paginate($request->per_page??15));
    }
    public function store(Request $request): JsonResponse {
        $data = $request->validate(['company_name'=>'required|string','email'=>'nullable|email','phone'=>'nullable|string','website'=>'nullable|string','address'=>'nullable|string','city'=>'nullable|string','state'=>'nullable|string','zip'=>'nullable|string','country'=>'nullable|string','currency'=>'nullable|string|size:3','status'=>'in:active,inactive','vat_number'=>'nullable|string','notes'=>'nullable|string']);
        return response()->json(Client::create($data),201);
    }
    public function show(Client $client): JsonResponse { return response()->json($client->loadCount(['projects','invoices'])); }
    public function update(Request $request, Client $client): JsonResponse { $client->update($request->all()); return response()->json($client->fresh()); }
    public function destroy(Client $client): JsonResponse { $client->delete(); return response()->json(null,204); }
    public function projects(Client $client): JsonResponse { return response()->json($client->projects()->withCount('tasks')->latest()->get()); }
    public function invoices(Client $client): JsonResponse { return response()->json($client->invoices()->latest()->paginate(10)); }
    public function contacts(Client $client): JsonResponse { return response()->json($client->contacts); }
}
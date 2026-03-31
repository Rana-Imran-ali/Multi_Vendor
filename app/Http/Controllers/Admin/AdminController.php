<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
{
    return User::latest()->get();
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
{
    return User::findOrFail($id);
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $user = User::findOrFail($id);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role
    ]);

    return response()->json($user);
}

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
{
    User::destroy($id);

    return response()->json([
        'message' => 'User deleted successfully'
    ]);
}

// Approve a vendor
public function approveVendor($id)
{
    $vendor = User::findOrFail($id);

    if ($vendor->role !== 'vendor') {
        return response()->json(['message' => 'Not a vendor'], 400);
    }

    $vendor->is_approved = true;
    $vendor->save();

    return response()->json([
        'message' => 'Vendor approved successfully'
    ]);
}
   //admin dashboard
   public function dashboard()
{
    return response()->json([
        'total_users' => User::where('role', 'customer')->count(),
        'total_vendors' => User::where('role', 'vendor')->count(),
        'pending_vendors' => User::where('role', 'vendor')->where('is_approved', false)->count(),
        'total_orders' => Order::count(),
        'total_products' => Product::count(),
    ]);
}
}

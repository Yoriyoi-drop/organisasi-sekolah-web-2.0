<?php
namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Facades\Cache;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Cache::remember('all_organizations', 3600, function () {
            return Organization::select('id', 'name', 'type', 'description', 'icon', 'color', 'tagline')
                             ->where('is_active', true)
                             ->orderBy('order')
                             ->get();
        });
        
        return view('organisasi.index', compact('organizations'));
    }

    public function show($id)
    {
        $organization = Organization::with(['students', 'teachers'])->findOrFail($id);
        return view('organisasi.show', compact('organization'));
    }
}

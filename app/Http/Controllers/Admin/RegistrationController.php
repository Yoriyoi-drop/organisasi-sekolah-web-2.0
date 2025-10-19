<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Student;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('organization')
                                   ->latest()
                                   ->paginate(15);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        $registration->load('organization');
        return view('admin.registrations.show', compact('registration'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $registration->update(['status' => $request->status]);

        if ($request->status === 'approved') {
            // Create or find student based on unique identifiers (prefer email, fallback to NIS)
            $student = null;

            if (!empty($registration->email)) {
                $student = Student::firstOrCreate(
                    ['email' => $registration->email],
                    [
                        'name' => $registration->name,
                        'phone' => $registration->phone,
                        'class' => $registration->class,
                        'address' => $registration->address,
                    ]
                );
            }

            if (!$student && !empty($registration->nis)) {
                // If email is missing, try to find by name+nis combination
                $student = Student::firstOrCreate(
                    ['name' => $registration->name, 'phone' => $registration->phone],
                    [
                        'email' => $registration->email,
                        'class' => $registration->class,
                        'address' => $registration->address,
                    ]
                );
            }

            if ($student) {
                // Attach to organization as member (many-to-many)
                $registration->organization
                    ->students()
                    ->syncWithoutDetaching([$student->id]);
            }
        }

        return redirect()->route('admin.registrations.index')
                        ->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();
        return redirect()->route('admin.registrations.index')
                        ->with('success', 'Data pendaftaran berhasil dihapus.');
    }
}

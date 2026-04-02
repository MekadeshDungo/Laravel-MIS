<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceForm;
use App\Models\FormSubmission;

class ServiceFormController extends Controller
{
    /**
     * Display a listing of forms (admin view).
     */
    public function index(Request $request)
    {
        $query = ServiceForm::query();

        if ($request->has('type') && $request->type) {
            $query->where('form_type', $request->type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active');
        }

        $forms = $query->with('creator')->latest()->paginate(10);

        return view('service-forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new form.
     */
    public function create()
    {
        return view('service-forms.create');
    }

    /**
     * Store a newly created form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|string|in:kapon,vaccination,pet_registration,adoption,bite_report,stray_report,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['is_active'] = $request->has('is_active');

        ServiceForm::create($validated);

        return redirect()->route('service-forms.index')
            ->with('success', 'Service form created successfully!');
    }

    /**
     * Display the specified form.
     */
    public function show(ServiceForm $serviceForm)
    {
        $serviceForm->load('announcements', 'submissions');
        return view('service-forms.show', compact('serviceForm'));
    }

    /**
     * Show the form for editing the form.
     */
    public function edit(ServiceForm $serviceForm)
    {
        return view('service-forms.edit', compact('serviceForm'));
    }

    /**
     * Update the specified form.
     */
    public function update(Request $request, ServiceForm $serviceForm)
    {
        $validated = $request->validate([
            'form_type' => 'required|string|in:kapon,vaccination,pet_registration,adoption,bite_report,stray_report,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $serviceForm->update($validated);

        return redirect()->route('service-forms.index')
            ->with('success', 'Service form updated successfully!');
    }

    /**
     * Remove the specified form.
     */
    public function destroy(ServiceForm $serviceForm)
    {
        $serviceForm->delete();
        return redirect()->route('service-forms.index')
            ->with('success', 'Service form deleted successfully!');
    }

    /**
     * View form submissions.
     */
    public function submissions(ServiceForm $serviceForm, Request $request)
    {
        $query = $serviceForm->submissions();

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $submissions = $query->with('submitter')->latest()->paginate(10);

        return view('service-forms.submissions', compact('serviceForm', 'submissions'));
    }

    /**
     * Approve a submission.
     */
    public function approveSubmission(FormSubmission $submission)
    {
        $submission->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Submission approved!');
    }

    /**
     * Reject a submission.
     */
    public function rejectSubmission(Request $request, FormSubmission $submission)
    {
        $request->validate([
            'review_notes' => 'required|string',
        ]);

        $submission->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'review_notes' => $request->review_notes,
        ]);

        return back()->with('success', 'Submission rejected!');
    }

    /**
     * Public form submission handler.
     */
    public function submit(Request $request, ServiceForm $serviceForm)
    {
        $validated = $request->validate([
            'citizen_name' => 'required|string|max:255',
            'citizen_contact' => 'nullable|string|max:255',
            'citizen_address' => 'nullable|string',
        ]);

        // Capture all form data except CSRF and known fields
        $payload = $request->all();
        unset($payload['_token'], $payload['citizen_name'], $payload['citizen_contact'], $payload['citizen_address']);

        FormSubmission::create([
            'form_id' => $serviceForm->id,
            'submitted_by_user_id' => Auth::check() ? Auth::id() : null,
            'citizen_name' => $validated['citizen_name'],
            'citizen_contact' => $validated['citizen_contact'] ?? null,
            'citizen_address' => $validated['citizen_address'] ?? null,
            'payload_json' => $payload,
            'submitted_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }

    /**
     * API: Store a newly created form submission (public).
     */
    public function apiStore(Request $request)
    {
        $validated = $request->validate([
            'form_type' => 'required|string|in:kapon,vaccination,pet_registration,adoption,bite_report,stray_report,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['created_by'] = Auth::check() ? Auth::id() : null;
        $validated['is_active'] = $request->has('is_active');

        $form = ServiceForm::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Service form created successfully!',
            'data' => $form
        ], 201);
    }

    /**
     * API: Display a listing of forms.
     */
    public function apiIndex(Request $request)
    {
        $query = ServiceForm::query();

        if ($request->has('type') && $request->type) {
            $query->where('form_type', $request->type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('is_active', $request->status === 'active');
        }

        $forms = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $forms
        ]);
    }

    /**
     * API: Display the specified form.
     */
    public function apiShow(ServiceForm $serviceForm)
    {
        $serviceForm->load('announcements', 'submissions');

        return response()->json([
            'success' => true,
            'data' => $serviceForm
        ]);
    }
}

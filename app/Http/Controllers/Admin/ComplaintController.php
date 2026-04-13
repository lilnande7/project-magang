<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        if ($status !== null && ! in_array($status, Complaint::statuses(), true)) {
            $status = null;
        }

        $query = Complaint::query()->with('admin');

        if ($status) {
            $query->where('status', $status);
        }

        $complaints = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            Complaint::STATUS_MASUK => Complaint::where('status', Complaint::STATUS_MASUK)->count(),
            Complaint::STATUS_DIPROSES => Complaint::where('status', Complaint::STATUS_DIPROSES)->count(),
            Complaint::STATUS_SELESAI => Complaint::where('status', Complaint::STATUS_SELESAI)->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'status', 'counts'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load('admin');

        return view('admin.complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:'.implode(',', Complaint::statuses())],
        ]);

        $newStatus = $validated['status'];

        $update = [
            'status' => $newStatus,
            'admin_id' => auth()->id(),
        ];

        if ($newStatus === Complaint::STATUS_DIPROSES && $complaint->processed_at === null) {
            $update['processed_at'] = now();
        }

        if ($newStatus === Complaint::STATUS_SELESAI && $complaint->completed_at === null) {
            $update['completed_at'] = now();
        }

        $complaint->update($update);

        return redirect()->route('admin.complaints.show', $complaint)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }
}

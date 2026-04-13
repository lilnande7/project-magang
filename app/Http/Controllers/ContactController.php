<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function show()
    {
        return view('hubungikami.index', [
            'title' => 'Hubungi Kami - Perpustakaan PPIC'
        ]);
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $data['ip'] = $request->ip();
        $data['user_agent'] = $request->userAgent();

        Complaint::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
            'status' => Complaint::STATUS_MASUK,
            'ip' => $data['ip'],
            'user_agent' => $data['user_agent'] ? mb_substr($data['user_agent'], 0, 512) : null,
        ]);

        $recipient = config('mail.from.address', 'admin@example.com');

        try {
            Mail::to($recipient)->send(new ContactMessageMail($data));
        } catch (\Throwable) {
            // Keep UX simple: complaint is stored even if email fails.
        }

        return back()->with('success', 'Pesan berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }
}

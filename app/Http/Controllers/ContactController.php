<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
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

        $recipient = config('mail.from.address', 'admin@example.com');

        Mail::to($recipient)->send(new ContactMessageMail($data));

        return back()->with('success', 'Pesan berhasil dikirim. Tim kami akan segera menghubungi Anda.');
    }
}

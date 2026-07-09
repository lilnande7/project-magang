<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\Complaint;

class ContactController extends Controller
{
    public function index()
    {
        return view('hubungikami.index');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email',
            'message' => 'required|max:2000',
        ]);

        $data = $request->only(['name', 'email', 'message']);

        try {
            Mail::to('ppicurug.library@gmail.com')
                ->send(
                    (new ContactMail($data))
                    ->replyTo($request->email, $request->name)
                );

            return back()->with('success', 'Pesan berhasil dikirim.');
        } catch (\Throwable $e) {
            Log::error('Contact form mail send failed: ' . $e->getMessage(), ['exception' => $e]);

            // Persist the message so admins can handle it later
            Complaint::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'message' => $data['message'],
                'status' => Complaint::STATUS_MASUK,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return back()->with('success', 'Pesan diterima. Kami akan menindaklanjuti walau pengiriman email gagal.');
        }
    }
}   
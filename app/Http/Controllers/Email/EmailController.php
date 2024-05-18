<?php

namespace App\Http\Controllers\Email;

use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;

class EmailController extends Controller
{
    public function sendWelcomeEmails()
    {
        $title = 'Welcome to the laracoding.com example email';
        $body = 'Thank you for participating!';

        Mail::to('kamranafridi089@gmail.com')->send(new WelcomeMail($title, $body));

        return "Email sent successfully!";
    }
    public function sendWelcomeEmail()
    {
        ini_set('max_execution_time', 120);
        $order = Order::with(['customer', 'details'])->where('uuid', 'd3d35bf7-c397-4618-9c2f-e7d5b12e842f')->firstOrFail();
        // TODO refactoring 
        $data = [
            "email" => "kamranafridi089@gmail.com",
            "title" => "From pantherforce.co.uk",
            "body" => 'Invoice',
        ];
        $pdf = PDF::loadView('emails.invoice', compact('order'));
        // dd($pdf);
        Mail::send('emails.message', $data, function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"]) 
                ->attachData($pdf->output(), "Invoice.pdf", [
                    'mime' => 'application/pdf',
                ]);
        });
        dd("asda");



        dd('Mail sent successfully');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    // Show the contact form
    public function show()
    {
        return view('contact');
    }

    // Send email
    public function sendEmail(Request $request)
    {
        // Validate form
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:10'
        ]);

        // Send email

        // Flash filled-in form values to the session
        $request->flash();
        // Flash a success message to the session
        session()->flash('success', 'Thank you for your message.<br>We\'ll contact you as soon as possible.');

        // Redirect to the contact-us link ( NOT to view('contact')!!! )
        return redirect('contact-us');
    }
}

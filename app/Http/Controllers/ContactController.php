<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view ('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email',
            'phone_number' => 'required|numeric|digits_between:5,15',
        ]);

        //-------CARA 1 : Intantiate menjadi object-------
        // $newContact = new Contact();
        // $newContact->full_name = $validated['full_name'];
        // $newContact->email = $validated['email'];
        // $newContact->phone_number = $validated['phone_number'];

        // $newContact->save();

        //CARA 2 : Mass Asignment Array Asosiative
        // $contact = Contact::create([
        //     'full_name' => $validated['full_name'],
        //     'email' => $validated['email'],
        //     'phone_number' => $validated['phone_number'],
        // ]);

        //CARA 3 : Mass Asignment Array Asosiative lebih simple
        $contact = Contact::create($validated);

        return redirect()->route('contact-us.index')->with('success', 'Thank you, we will contact you soon!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        Message::create($request->validated());

        return to_route('contact')->with('status', 'Your message has been sent to the Head of Department.');
    }
}

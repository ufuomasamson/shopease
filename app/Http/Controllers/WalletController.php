<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user's wallet
     */
    public function show()
    {
        $user = auth()->user();
        $wallet = $user->wallet ?? $user->wallet()->create();
        $transactions = $wallet->transactions()->latest()->paginate(10);

        return view('wallet.show', compact('wallet', 'transactions'));
    }
}

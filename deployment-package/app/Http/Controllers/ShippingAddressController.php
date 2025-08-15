<?php

namespace App\Http\Controllers;

use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Auth::user()->shippingAddresses()->orderBy('is_default', 'desc')->get();
        return view('shipping-addresses.index', compact('addresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shipping-addresses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'additional_notes' => 'nullable|string|max:500',
            'is_default' => 'boolean',
            'is_billing_address' => 'boolean',
        ]);

        // If this is set as default, unset other default addresses
        if ($request->boolean('is_default')) {
            Auth::user()->shippingAddresses()->update(['is_default' => false]);
        }

        // If this is set as billing address, unset other billing addresses
        if ($request->boolean('is_billing_address')) {
            Auth::user()->shippingAddresses()->update(['is_billing_address' => false]);
        }

        $address = Auth::user()->shippingAddresses()->create($request->all());

        return redirect()->route('shipping-addresses.index')
            ->with('success', 'Shipping address added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShippingAddress $shippingAddress)
    {
        // Ensure user owns this address
        if ($shippingAddress->user_id !== Auth::id()) {
            abort(403);
        }

        return view('shipping-addresses.show', compact('shippingAddress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShippingAddress $shippingAddress)
    {
        // Ensure user owns this address
        if ($shippingAddress->user_id !== Auth::id()) {
            abort(403);
        }

        return view('shipping-addresses.edit', compact('shippingAddress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShippingAddress $shippingAddress)
    {
        // Ensure user owns this address
        if ($shippingAddress->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'additional_notes' => 'nullable|string|max:500',
            'is_default' => 'boolean',
            'is_billing_address' => 'boolean',
        ]);

        // If this is set as default, unset other default addresses
        if ($request->boolean('is_default')) {
            Auth::user()->shippingAddresses()->where('id', '!=', $shippingAddress->id)->update(['is_default' => false]);
        }

        // If this is set as billing address, unset other billing addresses
        if ($request->boolean('is_billing_address')) {
            Auth::user()->shippingAddresses()->where('id', '!=', $shippingAddress->id)->update(['is_billing_address' => false]);
        }

        $shippingAddress->update($request->all());

        return redirect()->route('shipping-addresses.index')
            ->with('success', 'Shipping address updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShippingAddress $shippingAddress)
    {
        // Ensure user owns this address
        if ($shippingAddress->user_id !== Auth::id()) {
            abort(403);
        }

        $shippingAddress->delete();

        return redirect()->route('shipping-addresses.index')
            ->with('success', 'Shipping address removed successfully!');
    }

    /**
     * Set an address as default
     */
    public function setDefault(ShippingAddress $shippingAddress)
    {
        // Ensure user owns this address
        if ($shippingAddress->user_id !== Auth::id()) {
            abort(403);
        }

        // Unset other default addresses
        Auth::user()->shippingAddresses()->update(['is_default' => false]);
        
        // Set this as default
        $shippingAddress->update(['is_default' => true]);

        return redirect()->route('shipping-addresses.index')
            ->with('success', 'Default address updated successfully!');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingAddress extends Model
{
    protected $fillable = [
        'user_id', 'first_name', 'last_name', 'phone', 'email',
        'address_line_1', 'address_line_2', 'city', 'state',
        'postal_code', 'country', 'additional_notes',
        'is_default', 'is_billing_address'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_billing_address' => 'boolean',
    ];

    /**
     * Get the user who owns this address
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get orders shipped to this address
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get full name
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get full address
     */
    public function getFullAddressAttribute(): string
    {
        $address = $this->address_line_1;
        
        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }
        
        $address .= ', ' . $this->city . ', ' . $this->state . ' ' . $this->postal_code . ', ' . $this->country;
        
        return $address;
    }

    /**
     * Get short address (city, state)
     */
    public function getShortAddressAttribute(): string
    {
        return $this->city . ', ' . $this->state;
    }

    /**
     * Scope for default addresses
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope for billing addresses
     */
    public function scopeBilling($query)
    {
        return $query->where('is_billing_address', true);
    }

    /**
     * Scope for shipping addresses
     */
    public function scopeShipping($query)
    {
        return $query->where('is_billing_address', false);
    }

    /**
     * Check if this is the user's default address
     */
    public function isDefault(): bool
    {
        return $this->is_default;
    }

    /**
     * Check if this is a billing address
     */
    public function isBillingAddress(): bool
    {
        return $this->is_billing_address;
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhoneAttribute(): string
    {
        // Basic phone formatting - you can enhance this
        return $this->phone;
    }

    /**
     * Get country flag emoji (basic implementation)
     */
    public function getCountryFlagAttribute(): string
    {
        $countryFlags = [
            'Nigeria' => '🇳🇬',
            'Ghana' => '🇬🇭',
            'Kenya' => '🇰🇪',
            'South Africa' => '🇿🇦',
            'Egypt' => '🇪🇬',
            'Morocco' => '🇲🇦',
            'Tunisia' => '🇹🇳',
            'Algeria' => '🇩🇿',
            'Ethiopia' => '🇪🇹',
            'Uganda' => '🇺🇬',
            'Tanzania' => '🇹🇿',
            'Rwanda' => '🇷🇼',
            'Burundi' => '🇧🇮',
            'Somalia' => '🇸🇴',
            'Djibouti' => '🇩🇯',
            'Eritrea' => '🇪🇷',
            'Sudan' => '🇸🇩',
            'South Sudan' => '🇸🇸',
            'Chad' => '🇹🇩',
            'Niger' => '🇳🇪',
            'Mali' => '🇲🇱',
            'Burkina Faso' => '🇧🇫',
            'Senegal' => '🇸🇳',
            'Gambia' => '🇬🇲',
            'Guinea-Bissau' => '🇬🇼',
            'Guinea' => '🇬🇳',
            'Sierra Leone' => '🇸🇱',
            'Liberia' => '🇱🇷',
            'Ivory Coast' => '🇨🇮',
            'Togo' => '🇹🇬',
            'Benin' => '🇧🇯',
            'Cameroon' => '🇨🇲',
            'Central African Republic' => '🇨🇫',
            'Equatorial Guinea' => '🇬🇶',
            'Gabon' => '🇬🇦',
            'Republic of the Congo' => '🇨🇬',
            'Democratic Republic of the Congo' => '🇨🇩',
            'Angola' => '🇦🇴',
            'Zambia' => '🇿🇲',
            'Zimbabwe' => '🇿🇼',
            'Botswana' => '🇧🇼',
            'Namibia' => '🇳🇦',
            'Lesotho' => '🇱🇸',
            'Eswatini' => '🇸🇿',
            'Madagascar' => '🇲🇬',
            'Mauritius' => '🇲🇺',
            'Seychelles' => '🇸🇨',
            'Comoros' => '🇰🇲',
            'Mayotte' => '🇾🇹',
            'Réunion' => '🇷🇪',
            'Cape Verde' => '🇨🇻',
            'São Tomé and Príncipe' => '🇸🇹',
            'Guinea' => '🇬🇳',
            'Mauritania' => '🇲🇷',
            'Western Sahara' => '🇪🇭',
            'Libya' => '🇱🇾',
            'Chad' => '🇹🇩',
            'Niger' => '🇳🇪',
            'Mali' => '🇲🇱',
            'Burkina Faso' => '🇧🇫',
            'Senegal' => '🇸🇳',
            'Gambia' => '🇬🇲',
            'Guinea-Bissau' => '🇬🇼',
            'Guinea' => '🇬🇳',
            'Sierra Leone' => '🇸🇱',
            'Liberia' => '🇱🇷',
            'Ivory Coast' => '🇨🇮',
            'Togo' => '🇹🇬',
            'Benin' => '🇧🇯',
            'Cameroon' => '🇨🇲',
            'Central African Republic' => '🇨🇫',
            'Equatorial Guinea' => '🇬🇶',
            'Gabon' => '🇬🇦',
            'Republic of the Congo' => '🇨🇬',
            'Democratic Republic of the Congo' => '🇨🇩',
            'Angola' => '🇦🇴',
            'Zambia' => '🇿🇲',
            'Zimbabwe' => '🇿🇼',
            'Botswana' => '🇧🇼',
            'Namibia' => '🇳🇦',
            'Lesotho' => '🇱🇸',
            'Eswatini' => '🇸🇿',
            'Madagascar' => '🇲🇬',
            'Mauritius' => '🇲🇺',
            'Seychelles' => '🇸🇨',
            'Comoros' => '🇰🇲',
            'Mayotte' => '🇾🇹',
            'Réunion' => '🇷🇪',
            'Cape Verde' => '🇨🇻',
            'São Tomé and Príncipe' => '🇸🇹',
            'Guinea' => '🇬🇳',
            'Mauritania' => '🇲🇷',
            'Western Sahara' => '🇪🇭',
            'Libya' => '🇱🇾',
        ];
        
        return $countryFlags[$this->country] ?? '🌍';
    }
}

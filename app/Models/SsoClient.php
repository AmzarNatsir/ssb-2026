<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SsoClient extends Model
{
    protected $table = 'sso_clients';

    protected $fillable = [
        'oauth_client_id', 'name', 'slug', 'description', 'logo', 'is_active', 'trusted',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'trusted'   => 'boolean',
    ];

    /**
     * Relasi ke kredensial OAuth (oauth_clients) milik Passport.
     */
    public function oauthClient()
    {
        return $this->belongsTo(\App\Models\Passport\Client::class, 'oauth_client_id');
    }
}

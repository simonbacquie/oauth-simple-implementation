<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

final class OauthClient extends Model {

    public function registeredScopeIds() {
        return DB::table('oauth_client_scopes')->distinct('scope_id')->where('client_id', $this->attributes['id'])->pluck('scope_id');
    }

    public function registeredScopeDescriptions() {
        return DB::table('oauth_scopes')->whereIn('id', $this->registeredScopeIds())->pluck('description');
    }
}

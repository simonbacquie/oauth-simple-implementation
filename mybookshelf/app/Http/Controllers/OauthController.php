<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Illuminate\Support\Facades\Auth;

use App\Models\OauthClient;


class OauthController extends Controller
{

    public function __construct() {
        $this->middleware(['web', 'auth', 'check-authorization-params']);
    }

    public function login_screen(Request $request) {
        $authParams = Authorizer::getAuthCodeRequestParams();

        $formParams = array_except($authParams,'client');

        $formParams['client_id'] = $authParams['client']->getId();

        $client = OauthClient::find($formParams['client_id']);

        // only use scopes as they come from the database, ignore those passed into the request params
        $authParams['scopes'] = $client->registeredScopeIds();

        $formParams['scope'] = implode(config('oauth2.scope_delimiter'), $authParams['scopes']);
        $formParams['scope_descriptions'] = $client->registeredScopeDescriptions();

        return view('oauth.authorization_form', ['params' => $formParams, 'client' => $authParams['client']]);
    }

    public function login_submit(Request $request) {
        $params = Authorizer::getAuthCodeRequestParams();
        $params['user_id'] = Auth::user()->id;
        $redirectUri = '/';

        // If the user has allowed the client to access its data, redirect back to the client with an auth code.
        if ($request->has('approve')) {
            $redirectUri = Authorizer::issueAuthCode('user', $params['user_id'], $params);
        }

        // If the user has denied the client to access its data, redirect back to the client with an error message.
        if ($request->has('deny')) {
            $redirectUri = Authorizer::authCodeRequestDeniedRedirectUri();
        }

        return redirect($redirectUri);
    }

}

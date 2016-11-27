<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Kozz\Laravel\Facades\Guzzle;
use GuzzleHttp\Exception\RequestException;

class MyBookshelfClient {

    const CLIENT_ID             = 'wormrate';
    const CLIENT_SECRET         = 'wormsecret';
    const LOGIN_SCREEN_ENDPOINT = 'http://mybookshelf.app/oauth/authorize';
    const TOKEN_ENDPOINT        = 'http://mybookshelf.app/oauth/access_token';
    const BOOKS_ENDPOINT        = 'http://mybookshelf.app/api/books';
    const REDIRECT_URI          = 'http%3A%2F%2Fwormrate.app%2Fmybookshelf';

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    static function loginScreenUrl() {
        return self::LOGIN_SCREEN_ENDPOINT . '?client_id=' . self::CLIENT_ID . '&redirect_uri=' . self::REDIRECT_URI . '&response_type=code';
    }

    public function activateAuthorizationCode($code) {
        $response = Guzzle::post(self::TOKEN_ENDPOINT, [
                'form_params' => [
                    'code'          => $code,
                    'grant_type'    => 'authorization_code',
                    'client_id'     => self::CLIENT_ID,
                    'client_secret' => self::CLIENT_SECRET,
                    'redirect_uri'  => urldecode(self::REDIRECT_URI),
        ]]);

        $activation_json = json_decode($response->getBody());
        $this->storeNewTokenOnUserRecord($activation_json->access_token, $activation_json->refresh_token);
    }

    public function storeNewTokenOnUserRecord($access_token, $refresh_token) {
        $this->user->mybookshelf_access_token  = $access_token;
        $this->user->mybookshelf_refresh_token = $refresh_token;
        $this->user->save();
    }

    public function useRefreshToken() {
        $response = Guzzle::post(self::TOKEN_ENDPOINT, [
                'form_params' => [
                    'grant_type'    => 'refresh_token',
                    'refresh_token' => $this->user->mybookshelf_refresh_token,
                    'client_id'     => self::CLIENT_ID,
                    'client_secret' => self::CLIENT_SECRET,
        ]]);
        $new_token_response = json_decode($response->getBody());
        $this->storeNewTokenOnUserRecord($new_token_response->access_token, $new_token_response->refresh_token);
    }

    public function getBooksForUser($triesLeft = 3) {
        try {
            $response = Guzzle::get(self::BOOKS_ENDPOINT, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->user->mybookshelf_access_token
            ]]);
        } catch (RequestException $e) {
            if ($e->getResponse()->getStatusCode() !== 200 && $triesLeft) {
                $this->useRefreshToken();
                $this->getBooksForUser($triesLeft - 1);
                return false;
            }
        }
        return json_decode($response->getBody());
    }

}

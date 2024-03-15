<?php

namespace Joytekmotion\Zoho\Oauth;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Joytekmotion\Zoho\Oauth\Contracts\Client;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class SelfClient implements Client
{
    const ENDPOINT = '/oauth/v2/token';
    protected string $clientId;
    protected string $clientSecret;
    protected string $baseUrl;
    protected string|null $refreshToken;

    public function __construct(string $baseUrl, string $clientId, string $clientSecret, string $refreshToken = null)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->refreshToken = $refreshToken;
        $this->baseUrl = $baseUrl;
    }

    /**
     * @throws RequestException
     */
    public function generateRefreshToken(string $code): string
    {
        $response = $this->makeRequest(array_merge($this->defaultBodyParams(), [
            'grant_type' => 'authorization_code',
            'code' => $code
        ]));
        return $response['refresh_token'];
    }

    /**
     * @throws RequestException
     */
    protected function makeRequest(array $body): array
    {
        $response = Http::asForm()->post($this->baseUrl . self::ENDPOINT, $body);

        if (!$response->successful()) {
            $response->throw();
        }

        return $response->json();
    }

    /**
     * @throws RequestException|UnprocessableEntityHttpException
     */
    public function generateAccessToken(): string
    {
        if (!$this->refreshToken) {
            throw new UnprocessableEntityHttpException('Refresh token is required!');
        }
        $response = $this->makeRequest(array_merge($this->defaultBodyParams(), [
            'refresh_token' => $this->refreshToken,
            'grant_type' => 'refresh_token'
        ]));
        if (!isset($response['access_token'])) {
            throw new UnprocessableEntityHttpException('Access token not found in response');
        }
        return $response['access_token'];
    }

    public function defaultBodyParams(): array
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ];
    }
}

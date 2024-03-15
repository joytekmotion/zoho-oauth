<?php

namespace Joytekmotion\Zoho\Oauth;

use GuzzleHttp\Exception\RequestException;
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

    protected string|null $accessToken;

    protected int|null $expiryTime;

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
     * @throws RequestException
     */
    public function generateAccessToken(): string
    {
        if (!$this->accessToken || time() >= $this->expiryTime) {
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
            $accessToken = $response['access_token'];
            // 1 hour expiry time
            $this->expiryTime = time() + 3600;
            $this->accessToken = $accessToken;
        }
        return $this->accessToken;
    }

    public function defaultBodyParams(): array
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret
        ];
    }
}

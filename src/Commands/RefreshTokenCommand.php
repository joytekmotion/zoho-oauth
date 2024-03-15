<?php

namespace Joytekmotion\Zoho\Oauth\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use Joytekmotion\Zoho\Oauth\SelfClient;

class RefreshTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zoho-oauth:refresh-token {code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a new refresh token when a zoho code is provided.';

    /**
     * Execute the console command.
     * @throws RequestException
     */
    public function handle(): void
    {
        $clientId = config('zoho.client_id');
        $clientSecret = config('zoho.client_secret');
        if (!config('zoho.client_secret') || !config('zoho.client_id'))
            $this->error('Please configure ZOHO_CLIENT_ID and ZOHO_CLIENT_SECRET environment variables.');
        $client = new SelfClient(config('zoho.oauth_base_url'), $clientId, $clientSecret);
        $this->info('Generating Refresh Token...');
        $this->info($client->generateRefreshToken($this->argument('code')));
    }
}

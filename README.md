# Zoho Oauth Self Client for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/joytekmotion/zoho-oauth.svg?label=Packagist&style=flat-square)](https://packagist.org/packages/joytekmotion/zoho-workdrive)
[![License](https://img.shields.io/github/license/joytekmotion/zoho-oauth?label=License)](https://github.com/joytekmotion/zoho-workdrive/blob/1.x/LICENSE)

This package is a Laravel wrapper for the Zoho Oauth API. It provides a simple way to authenticate with Zoho Oauth API and get the refresh token.

## Requirements
* PHP 8.1 or higher
* Laravel 8.x or higher

## Installation

You can install this package via composer:

```bash
composer require joytekmotion/zoho-oauth
```

## Setup
* Add the following zoho credentials to your `.env` file:
    
```dotenv
ZOHO_CLIENT_ID=
ZOHO_CLIENT_SECRET=
ZOHO_REFRESH_TOKEN=
```

To get the `ZOHO_CLIENT_ID` and `ZOHO_CLIENT_SECRET`, you need to create a Zoho Self Client in the [Zoho Developer Console](https://accounts.zoho.com/developerconsole).

* Optional: You can publish the configuration file using the following command:

```bash
php artisan vendor:publish --provider="Joytekmotion\Zoho\Oauth\Providers\ZohoOauthServiceProvider"
```

* Optional: The service provider will be automatically registered by Laravel. If you need to manually register the service provider, add the following to your `config/app.php` file:

```php
'providers' => [
    ...
    Joytekmotion\Zoho\Oauth\Providers\ZohoOauthServiceProvider::class,
    ...
]
```

## Usage

### Generate Refresh Token through Command Line
* To generate refresh token, you can use the following command:

```bash
php artisan zoho-oauth:refresh-token {code}
```
Replace `{code}` with the authorization code you generated from [Zoho Developer Console](https://accounts.zoho.com/developerconsole), and copy the refresh token to your `.env` file.

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
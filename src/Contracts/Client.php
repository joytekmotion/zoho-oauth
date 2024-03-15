<?php

namespace Joytekmotion\Zoho\Oauth\Contracts;

interface Client
{
    public function generateAccessToken(): string;
}

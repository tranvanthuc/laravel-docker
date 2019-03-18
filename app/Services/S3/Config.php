<?php

namespace App\Services\S3;

use Aws\Credentials\Credentials;
use Aws\S3\S3Client;

class Config
{
    protected $s3;

    protected $bucket;

    public function __construct()
    {
        $credentials = new Credentials(config('aws.access_key'), config('aws.secret_key'));

        $this->s3 = new S3Client([
            'version'     => 'latest',
            'region'      => config('aws.region'),
            'credentials' => $credentials
        ]);

        $this->bucket = config('aws.s3_bucket');
    }
}

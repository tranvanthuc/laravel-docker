<?php

return [
    'access_key' => env('AWS_ACCESS_KEY_ID', 'AKIAJZNFIATTUQT5VUXA'),
    'secret_key' => env('AWS_SECRET_ACCESS_ID', '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'),
    'region'     => env('AWS_REGION', 'ap-northeast-1'),
    's3_bucket'  => env('S3_BUCKET', 'sdks3')
];

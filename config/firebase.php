<?php

return [
    'database_url' => env('FIREBASE_DATABASE_URL', 'https://fir-demo-7d357.firebaseio.com/'),
    'project_id'   => env('FIREBASE_PROJECT_ID'),
    'api_key'      => env('FIREBASE_API_KEY'),
    'bucket'       => env("FIREBASE_BUCKET"),
    'sender_id'    => env('FIREBASE_SENDER_ID'),
    'public_key'   => env('FIREBASE_PUBLIC_KEY')
];

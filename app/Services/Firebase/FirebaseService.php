<?php

namespace App\Services\FireBase;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Log;

class FirebaseService
{
    protected $firebase;

    public function __construct()
    {
        $path           = resource_path() . '/assets/firebase.json';
        $serviceAccount = ServiceAccount::fromJsonFile($path);
        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri(config('firebase.database_url'))
            ->create();


    }

    public function createThread($data)
    {
        $this->create("threads", $data);
    }

    /**
     * @param string $key
     * @param array $data
     */
    public function create($key = "default", $data = [])
    {
        try {
            $this->db->getReference($key)->push($data);
        } catch (\Exception $exception) {
            Log::error('[Create]: ' . $exception);
        }
    }

    /**
     * @param string $parent
     * @param array $condition
     *
     */
    public function getKeyValueByParent($parent = "default", $condition = ['user_id', 1])
    {
        list ($key, $value) = $condition;
        try {
            $result = $this->db
                ->getReference($parent)
                ->orderByChild($key)
                ->equalTo($value)
                ->getValue();
            $count  = count($result);
            if ($count > 0) {
                return [
                    'keys'   => array_keys($result),
                    'values' => array_values($result),
                    'total'  => $count
                ];
            }
        } catch (\Exception $exception) {
            Log::error('[Get key]: ' . $exception);
        }
        return [
            'keys'   => [],
            'values' => [],
            'total'  => 0
        ];
    }
}

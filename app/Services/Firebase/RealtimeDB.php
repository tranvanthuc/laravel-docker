<?php

namespace App\Services\FireBase;

use Log;

class RealtimeDB extends FirebaseService
{
    protected $db;
    public function __construct()
    {
        parent::__construct();
        $this->db = $this->firebase->getDatabase();
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

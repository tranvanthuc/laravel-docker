<?php

namespace App\Services\FireBase;

use App\Services\FireBaseService;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Log;

class Version2 extends FireBaseService
{
    protected $fireBase;

    protected $db;

    public function __construct()
    {
        parent::__construct();
        $path           = app_path('../resources/assets/firebase/' . config('firebase.key_json'));
        $this->fireBase = $serviceAccount = ServiceAccount::fromJsonFile($path);
        $this->fireBase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri(config('firebase.database_url'))
            ->create();

        $this->db = $this->fireBase->getDatabase();
    }

    public function createThread($params)
    {
        try {
            $this->db->getReference('threads')->push($params);
        } catch (\Exception $exception) {
            Log::error('[V2][CreateThread]: ' . $exception);
        }
    }

    public function updateThreadByAssessment($assessmentId, $params)
    {
        list($key, $data) = $this->getKeyThreadByAssessment($assessmentId);
        $newData = array_merge($data, $params);
        $this->db->getReference(strtr('threads/:key', [':key' => $key]))->set($newData);
    }

    public function getKeyThreadByAssessment($assessmentId)
    {
        try {
            $thread = $this->db
                ->getReference('threads')
                ->orderByChild('assessment_id')
                ->equalTo($assessmentId)
                ->getValue();
            if (count($thread) > 0) {
                return [array_keys($thread)[0], array_values($thread)[0]];
            }

            return [null, null];
        } catch (\Exception $exception) {
            Log::error('[V2][Get thread by Assessment]: ' . $exception);
        }
    }
}

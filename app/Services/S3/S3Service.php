<?php

namespace App\Services\S3;

class S3Service extends Config
{
    /**
     * S3Service constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $name
     */
    public function getFile($name)
    {
        try {
            $path   = $name;
            $path = "phpaxwBfH.png";
            $result = $this->s3->getObject([
                'ACL'                 => 'public-read',
                'Bucket'              => $this->bucket,
                'Key'                 => $path,
                'ResponseContentType' => 'image',
                'ResponseExpires'     => gmdate(DATE_RFC2822, time() + 60),
            ]);
           dd ( $result['Body']);
        } catch (\Exception $exception) {
            \Log::error($exception);
            dd($exception);
        }
    }

    /**
     * @param $params
     */
    public function putFile($params)
    {

    }
}

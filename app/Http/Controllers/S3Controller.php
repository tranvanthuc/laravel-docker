<?php

namespace App\Http\Controllers;

use App\Services\S3\S3Service;
use Storage;
use Illuminate\Http\Request;

class S3Controller extends Controller
{
    /** @var  S3Service $s3Service */
    protected $s3Service;

    public function __construct()
    {
        $this->s3Service = app(S3Service::class);
    }

    public function index() {

        $url = Storage::temporaryUrl(
            'YrL3ZOn32OdI4Lrg0qVrigOBpjOr4NxKYzBwp96W.png', now()->addMinutes(1)
        );
echo $url;
        return view('S3.index', compact('url'));
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('fileUpload')) {
            $file     = $request->file('fileUpload');
            \Storage::put('', $file);
        }

        return redirect(route('s3.index'));
    }
}

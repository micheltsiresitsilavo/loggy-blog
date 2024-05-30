<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use League\MimeTypeDetection\GeneratedExtensionToMimeTypeMap;

class AssetController extends Controller
{
    private function localAssets($folder, $filename)
    {
        $path = public_path($folder . '/' . $filename);
        if (file_exists($path)) {
            $map = new GeneratedExtensionToMimeTypeMap();
            $ext = pathinfo(public_path($filename), PATHINFO_EXTENSION);
            $mime = $map->lookupMimeType($ext);
            if (empty($mime)) {
                abort(404);
            }

            return response()->download($path, basename($filename), ['Content-Type' => $mime]);
        }
        else {
            abort(404);
        }
    }

    public function css(Request $request, $filename)
    {
        return $this->localAssets('css', $filename);
    }

    public function js(Request $request, $filename)
    {
        return $this->localAssets('js', $filename);
    }

    public function build(Request $request, $filename)
    {
        return $this->localAssets('build/assets/', $filename);
    }
}
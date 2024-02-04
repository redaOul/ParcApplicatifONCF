<?php

namespace App\Http\Controllers;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

/*
* C'est le contrôleur qui permet de gerer le stockage des fichiers massives en cours de la téléchargement.
* Tout d'abord, cette methode stocke les fichiers reduits (chunks) dans un repertoire temporaire "storage/app/chunks".
* Après que tous les fichiers reduits sont transmis avec succes, cette methode les groupe et placé ce fichier massives
* dans le chemin correspandant ($request->storagePath).
*/
class RecieverBigFiles extends Controller{
    /**
    * @return Application|Factory|View
    */

    public function uploadLargeFiles(Request $request) {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()){} // file not uploaded

        $fileReceived = $receiver->receive(); // receive file

        // file uploading is complete / all chunks are uploaded
        if ($fileReceived->isFinished()) {
            $file = $fileReceived->getFile(); // get file
            $path = '/' . Storage::put($request->storagePath, $file);
            
            // delete chunked file
            unlink($file->getPathname());
            return [
                'path' => $path
            ];
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true
        ];
    }
}

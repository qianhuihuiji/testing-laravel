<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadCsvUsers;

class UploadCsvController extends Controller
{
    public function upload(UploadCsvUsers $request)
    {
        $uploadedFile = $request->file('usersCsvFile')->openFile();

        $returnArray = collect();
        while (!$uploadedFile->eof()) {
            $returnArray->push($uploadedFile->fgets());
        }

        return $returnArray;
    }
}
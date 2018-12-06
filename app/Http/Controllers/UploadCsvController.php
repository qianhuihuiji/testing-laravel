<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadCsvController extends Controller
{
    public function upload(Request $request)
    {
        $uploadedFile = $request->file('usersCsvFile')->openFile();

        $returnArray = collect();
        while (!$uploadedFile->eof()) {
            $returnArray->push($uploadedFile->fgets());
        }

        return $returnArray;
    }
}
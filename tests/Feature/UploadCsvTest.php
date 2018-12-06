<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;

class UploadCsvTest extends TestCase
{
    use WithoutMiddleware;

    /** @test */
    public function it_can_upload_csv_successfully()
    {
        $response = $this->json('POST', 'upload-new-users-csv', [
            'usersCsvFile' => $this->createCsvUploadFile()
            ]);

        $response->assertStatus(200);

        $response->assertJson([
            "username,\"first name\",\"last name\"\n","jondoe,Jon,Doe\n","janedoe,Jane,Doe\n"
        ]);
    }

    protected function createUploadFile(vfsStreamFile $file,$originalName)
    {
        return new UploadedFile(
            $file->url(),
            $originalName,
            mime_content_type($file->url()),
            null,
            null,
            true
        );

    }

    protected function createVirtualFile($filename, $extension)
    {
        return vfsStream::setup(sys_get_temp_dir(), null, [$filename.'.'.$extension => '']);
    }

    protected function createCsvUploadFile($fileName = 'testFile')
    {
        $virtualFile = $this->createVirtualFile($fileName, 'csv')->getChild($fileName.'.csv');

        $fileResource = fopen($virtualFile->url(), 'a+');
        collect([
            ['username', 'first name', 'last name'],
            ['jondoe', 'Jon', 'Doe'],
            ['janedoe', 'Jane', 'Doe']
        ])->each(function ($fields) use ($fileResource) {
            fputcsv($fileResource, $fields);
        });
        fclose($fileResource);

        return $this->createUploadFile($virtualFile,$fileName);
    }
}
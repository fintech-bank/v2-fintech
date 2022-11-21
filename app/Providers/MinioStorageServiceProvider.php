<?php

namespace App\Providers;

use Aws\S3\S3Client;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Storage;

class MinioStorageServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        Storage::extend('minio', function () {
            $client = new S3Client([
                'credentials' => [
                    'key'    => config('filesystems.disks.s3.key'),
                    'secret' => config('filesystems.disks.s3.secret')
                ],
                'region'      => config('filesystems.disks.s3.region'),
                'version'     => "latest",
                'bucket_endpoint' => false,
                'use_path_style_endpoint' => true,
                'endpoint'    => config('filesystems.disks.s3.endpoint'),
            ]);
            $options = [
                'override_visibility_on_copy' => true
            ];
            return new Filesystem(new AwsS3Adapter($client, config('filesystems.disks.s3.endpoint'), '', $options));
        });
    }
}

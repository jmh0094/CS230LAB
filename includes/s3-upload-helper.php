<?php

require '../vendor/autoload.php';

use Aws\S3\S3Client;

use Aws\Exception\AwsException;

if(isset($_POST['s3-submit'])){

    $bucketName = "cs230labjmh-s3";

    $file = $_FILES['s3-image'];
    $file_name = $file['name'];
    $file_tmp_name = $file['tmp_name'];
    $file_error = $file['error'];
    $file_size = $file['size'];

    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    try {
        

        $s3Client = S3Client::factory(
            array('region'=>'us-east-1',
            'version'=>'latest',
            'credentials'=> array(
                'key'=>"AKIAQEC3KZNNCCC2DLGA",
                'secret'=>"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"
            )
            )
        );

        $result = $s3Client->putObject([

            'Bucket'=>$bucketName,
            'Key'=>'test_uploads/'.uniqid('',true).'.'.$ext,
            'SourceFile'=>$file_tmp_name,
            'ACL'=>'public-read'
        ]);

        echo 'Success! Photo URL: '.$result->get('ObjectURL');

    } catch (Aws\S3\Exception\S3Exception $e) {
        die('Error uploading file: '.$e->getMessage());
    }



}
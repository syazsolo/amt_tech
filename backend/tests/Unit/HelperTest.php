<?php

use App\Helpers\Helper;

test('StandardResponse: Success', function () {
    $response = Helper::StandardResponse(0, '');

    expect($response)->toBe([
        'errCode' => 0,
        'errMsg' => ''
    ]);
});

test('StandardResponse: Failed', function () {
    $response = Helper::StandardResponse(1001, 'Update User Failed');

    expect($response)->toBe([
        'errCode' => 1001,
        'errMsg' => 'Update User Failed'
    ]);
});

test('StandardResponse: Unknown', function () {
    $response = Helper::StandardResponse(1000, 'Unknown');

    expect($response)->toBe([
        'errCode' => 1000,
        'errMsg' => 'Unknown'
    ]);
});

test('RespondSuccess', function () {
    $response = Helper::StandardResponse(0, '');

    expect($response)->toBe([
        'errCode' => 0,
        'errMsg' => ''
    ]);
});

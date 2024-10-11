<?php

namespace Plugins\Tools;

class RequestJson
{

    public function __construct(){}

    public function requestJsonEncode(array $data, int $code): void
    {
        echo json_encode([
            $data,
            "code"  => $code
        ]);
    }


    public function requestJsonDecode(string $json): array
    {
        return json_decode($json);
    }



}
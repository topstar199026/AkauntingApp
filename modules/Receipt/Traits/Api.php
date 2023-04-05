<?php

namespace Modules\Receipt\Traits;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

use Illuminate\Support\Facades\Http;

trait Api
{
    public function getReceipts($path)
    {
        try {
            $filename = ($path);

            $ext = pathinfo($filename);

            $extension = 'image/jpeg';

            if ($ext['extension'] == "pdf") {
                $extension = 'application/pdf';
            }

            $cfile = new \CurlFile($filename, $extension, $filename);

            $data = array('file' => $cfile);

            $taggun_endpoint = 'https://api.taggun.io/api/receipt/v1/simple/file';

            $ch = curl_init();

            $options = array(
                CURLOPT_URL => $taggun_endpoint,
                CURLOPT_RETURNTRANSFER => true,
                CURLINFO_HEADER_OUT => true,
                CURLOPT_HEADER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => array(
                    'apikey:' . setting('receipt.api_key'),
                    'Accept: application/json',
                    'Content-Type: multipart/form-data'
                ),
                CURLOPT_POSTFIELDS => $data
            );

            curl_setopt_array($ch, $options);

            $result = curl_exec($ch);
            $header_info = curl_getinfo($ch, CURLINFO_HEADER_OUT);
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $header = substr($result, 0, $header_size);
            $body = substr($result, $header_size);

            curl_close($ch);

            return $body;
        } catch (Exception $exception) {
        }
    }

    //Mindee services
    public function mindeeClient($contents)
    {
        try {

            $apiURL = 'https://api.mindee.net/v1/products/mindee/expense_receipts/v3/predict';
            $postInput = [
                'document' => base64_encode($contents)
            ];

            $headers = [
                'Authorization' => 'Token ' . setting('receipt.api_key')
            ];

            $response = Http::withHeaders($headers)->post($apiURL, $postInput);

            return self::transportMindee(json_decode($response->getBody(), true));
        } catch (Exception $exception) {
        }
    }

    public function checkMindee($contents, $token)
    {
        $apiURL = 'https://api.mindee.net/v1/products/mindee/expense_receipts/v3/predict';
        $postInput = [
            'document' => $contents
        ];

        $headers = [
            'Authorization' => 'Token ' . $token
        ];

        $response = Http::withHeaders($headers)->post($apiURL, $postInput);

        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        return $statusCode;
    }

    protected static function transportMindee($response): array
    {
        $result = [];

        if (array_key_exists('document',
                $response) && count($predictions = $response['document']['inference']['pages']) > 0) {
            $obj = $predictions[0]['prediction'];

            $result['totalAmount'] = $obj['total_incl']['value'] ?? '';
            $result['merchantName'] = $obj['supplier']['value'] ?? '';
            $result['date'] = $obj['date']['value'] ?? '';
            $result['probability'] = $obj['total_incl']['probability'] ?? '';
            $result['predictedCategory'] = $obj['category']['value'] ?? '';
            $result['processingTime'] = $response['call']['processing_time'] ?? '';
            $result['taxes'] = $obj['taxes'][0]['value'] ?? 0;
        }

        return $result;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Illuminate\Support\Facades\Http;


class DomainCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // return $next($request);

        $code = env('code');
        $domain = url('/');
        $app_name = env('APP_NAME');
        $type = env('type');


        $curl = curl_init();

        // Build the URL with variables properly concatenated
        $url = "https://demo.freaktemplate.com/domaincheck/api/get_code?code={$code}&domain={$domain}&app_name={$app_name}&type={$type}";

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $responseArray = json_decode($response, true);

        if (isset($responseArray['status'])) {
            $status = $responseArray['status'];

            if ($status == 1) {
                // Status is 1, proceed with next middleware or action
                return $next($request);
            } else {
                // Status is not 1, handle the message or error response
                return response()->json(['error' => $responseArray['msg']], 400);
            }
        } else {
            // Handle case where 'status' field is missing in the response
            return response()->json(['error' => 'Invalid response format'], 500);
        }
    }
}

<?php

namespace App\Services;


use GuzzleHttp\Client;

class CaspioService
{

    public static function getCaspioToken()
    {
      $client = new Client();
      $token_url = config('caspio.config.TokenEndpointURL');
      $data = "grant_type=client_credentials&client_id=".config('caspio.config.ClientID')."&client_secret=".config('caspio.config.ClientSecrect');
      $res = $client->request('POST', $token_url, ['body' =>  $data]);

      return json_decode($res->getBody()->getContents(), true)['access_token'];
    }

    public static function getTableRow($table,$query= '')
    {
      $client = new Client();
      $resource_url = config('caspio.config.ResourceEndpointURL');
      $token = self::getCaspioToken();
      $headers = ['Authorization' => 'Bearer '. $token];
      $url = $resource_url."/tables/$table/rows";
      if ($query != '' ){
        $url = $url . '?q={'.$query.'}';
      }
      $res = $client->request('GET', $url, ['headers' => $headers]);

      return json_decode($res->getBody()->getContents(), true);
    
    }

    public static function postToTable($table,$data = '')
    {
      $client = new Client();
      $resource_url = config('caspio.config.ResourceEndpointURL');
      $token = self::getCaspioToken();
      $headers = [
        'Authorization' => 'Bearer '. $token,
        'Content-Type'        => 'application/json'
      ];
      $url = $resource_url."/tables/$table/rows";
      $res = $client->request('POST', $url , ['headers' => $headers,'body' =>  $data]);

      return json_decode($res->getBody()->getContents(), true);
    
    }

    public static function updateToTable($table,$data = '',$query = '')
    {
      $client = new Client();
      $resource_url = config('caspio.config.ResourceEndpointURL');
      $token = self::getCaspioToken();
      $headers = [
        'Authorization' => 'Bearer '. $token,
        'Content-Type'        => 'application/json'
      ];
      $url = $resource_url."/tables/$table/rows";
      if ($query != '' ){
        $url = $url . '?q={'.$query.'}';
      }
      $res = $client->request('PUT', $url , ['headers' => $headers,'body' =>  $data]);

      return json_decode($res->getBody()->getContents(), true);
    }

    public static function deleteTableRow($table,$query = '')
    {
      $client = new Client();
      $resource_url = config('caspio.config.ResourceEndpointURL');
      $token = self::getCaspioToken();
      $headers = [
        'Authorization' => 'Bearer '. $token,
      ];
      $url = $resource_url."/tables/$table/rows";
      if ($query != '' ){
        $url = $url . '?q={'.$query.'}';
      }
      $res = $client->request('DELETE', $url , ['headers' => $headers]);

      return json_decode($res->getBody()->getContents(), true);
    }

}

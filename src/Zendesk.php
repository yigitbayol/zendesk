<?php

namespace Appricot\Zendesk;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Curl;

class Zendesk extends Controller
{

    public function getAllUsers()
    {
        $url = 'https://'.\Config::get('zendesk-laravel.domain').'.zendesk.com/api/v2/users.json';
        $username = \Config::get('zendesk-laravel.user').'/token';
        $token = \Config::get('zendesk-laravel.token');
        $bearer = base64_encode($username.':'.$token);

        $c = Curl::to($url)
        ->withHeader('Authorization: Basic '.$bearer)
        ->asJson()
        ->get();

        if ($c) {
          return $c;
        } else {
          return false;
        }
    }

    public function createUser($array)
    {
      $url = 'https://'.\Config::get('zendesk-laravel.domain').'.zendesk.com/api/v2/users/create_or_update.json';
      $username = \Config::get('zendesk-laravel.user').'/token';
      $token = \Config::get('zendesk-laravel.token');
      $bearer = base64_encode($username.':'.$token);

      $userdata['user'] = array(
        'name' => $array['name'],
        'email' => $array['email'],
        'verified' => 'true'
      );


      $c = Curl::to($url)
      ->withHeader('Authorization: Basic '.$bearer)
      ->withData( $userdata )
      ->asJson()
      ->post();

      if ($c) {
        if (isset($c->error)) {
          $r['type'] = 'error';
          $r['code'] = '1001';
          $r['message'] = 'There is already a user with that email address';
          return json_encode($r);
        } else {
          $r['type'] = 'success';
          $r['code'] = '1003';
          $r['message'] = 'User added successfully to zendesk';
          $r['user_id'] = $c->user->id;
          return json_encode($r);
        }
      } else {
        $r['type'] = 'error';
        $r['code'] = '1002';
        $r['message'] = 'There is something wrong while sending data';
        return json_encode($r);
      }
    }

    public function createTicket($array)
    {
      $url = 'https://'.\Config::get('zendesk-laravel.domain').'.zendesk.com/api/v2/tickets.json';
      $username = \Config::get('zendesk-laravel.user').'/token';
      $token = \Config::get('zendesk-laravel.token');
      $bearer = base64_encode($username.':'.$token);

      $ticketdata['ticket'] = array(
        'subject' => $array['subject'],
        'comment' => array(
          'body' => $array['content']
        ),
      	'requester' => array(
      	  "locale_id" => $array['staff_guid'],
      	  "name" => $array['staff_name'],
      	  "email" => $array['staff_email']
      	),
	      'type'=> 'problem',
        'tags' => array(
          $array['property_name'],
          $array['staff_name'],
          $array['job_id']
        )
      );

      $c = Curl::to($url)
      ->withHeader('Authorization: Basic '.$bearer)
      ->withData( $ticketdata )
      ->asJson()
      ->post();


      if ($c) {
        if (isset($c->error)) {
          $r['type'] = 'error';
          $r['code'] = '1001';
          $r['message'] = 'There is already a user with that email address';
          return json_encode($r);
        } else {
          $r['type'] = 'success';
          $r['code'] = '1003';
          $r['message'] = 'Ticket added successfully to zendesk';
          $r['user_id'] = $c->ticket->requester_id;
          return json_encode($r);
        }
      } else {
        $r['type'] = 'error';
        $r['code'] = '1002';
        $r['message'] = 'There is something wrong while sending data';
        return json_encode($r);
      }
    }
}

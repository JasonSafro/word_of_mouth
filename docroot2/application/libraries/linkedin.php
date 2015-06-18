<?php

require_once("OAuth.php");

class linkedin {

    var $base_url = "http://api.linkedin.com";
    var $secure_base_url = "https://api.linkedin.com";
    var $oauth_callback = "oob";
    var $consumer;
    var $token;
    var $method;
    var $http_status;
    var $last_api_call;
    var $callback;

    function linkedin($data) {
        $this->method = new OAuthSignatureMethod_HMAC_SHA1();
        $this->consumer = new OAuthConsumer($data['consumer_key'], $data['consumer_secret']);
        $this->callback = $data['callback_url'];

     //    print_r($data);


        if (!empty($data['oauth_token']) && !empty($data['oauth_token_secret']) && !empty($data['callback_url'])) {
            $this->token = new OAuthConsumer($data['oauth_token'], $data['oauth_token_secret']);
        } else {
            $this->token = NULL;
        }
    }

    function debug_info() {
        /* echo("Last API Call: " . $this->last_api_call . "<br />\n");
          echo("Response Code: " . $this->http_status . "<br />\n"); */
    }

    function get_request_token() {
        $args = array();

        $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, 'GET', "https://api.linkedin.com/uas/oauth/requestToken", $args);

        $request->set_parameter("oauth_callback", $this->callback);
        $request->sign_request($this->method, $this->consumer, $this->token);
        $request = $this->http($request->to_url());

        parse_str($request, $token);

        $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret'], $this->callback);

        return $token;
    }

    function getProfile($resource = "~") {
        $profile_url = $this->base_url . "/v1/people/" . $resource;
        $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, "GET", $profile_url);
        $request->sign_request($this->method, $this->consumer, $this->token);
        $auth_header = $request->to_header("https://api.linkedin.com"); # this is the realm
        # This PHP library doesn't generate the header correctly when a realm is not specified.
        # Make sure there is a space and not a comma after OAuth
        // $auth_header = preg_replace("/Authorization\: OAuth\,/", "Authorization: OAuth ", $auth_header);
        // # Make sure there is a space between OAuth attribute
        // $auth_header = preg_replace('/\"\,/', '", ', $auth_header);
        /*
          if ($debug) {
          echo $auth_header;
          }
         */
        // $response will now hold the XML document
        $response = $this->httpRequest($profile_url, $auth_header, "GET");
        return $response;
    }

    function get_access_token($oauth_verifier) {
        $args = array();

        $request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, 'GET', "https://api.linkedin.com/uas/oauth/accessToken", $args);
        $request->set_parameter("oauth_verifier", $oauth_verifier);
        $request->sign_request($this->method, $this->consumer, $this->token);
        $request = $this->http($request->to_url());

        //echo $request;

        parse_str($request, $token);
        //echo $oauth_verifier;

        $this->token = new OAuthConsumer($token['oauth_token'],
                        $token['oauth_token_secret'], 1);

        return $token;
    }

    function parse_request($string) {
        $args = explode("&", $string);
        $args[] = explode("=", $args['0']);
        $args[] = explode("=", $args['1']);

        $token[$args['2']['0']] = $args['2']['1'];
        $token[$args['3']['0']] = $args['3']['1'];

        return $token;
    }

    function parse_access($string) {
        $r = array();

        foreach (explode('&', $string) as $param) {
            $pair = explode('=', $param, 2);
            if (count($pair) != 2)
                continue;
            $r[urldecode($pair[0])] = urldecode($pair[1]);
        }
        return $r;
    }

    function get_authorize_URL($token) {
        if (is_array($token))
            $token = $token['oauth_token'];
        return "https://api.linkedin.com/uas/oauth/authorize?oauth_token=" .
                $token;
    }

    function http($url, $post_data = null) {
        $ch = curl_init();

        if (defined("CURL_CA_BUNDLE_PATH"))
            curl_setopt($ch, CURLOPT_CAINFO, CURL_CA_BUNDLE_PATH);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if (isset($post_data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        $response = curl_exec($ch);
        $this->http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $this->last_api_call = $url;
        curl_close($ch);

        return $response;
    }

    function share($comment, $title, $url, $imageUrl, $access_token) {
        $shareUrl = "http://api.linkedin.com/v1/people/~/shares";

        $xml = "<share>
              <comment>$comment</comment>
              <content>
                 <title>$title</title>
                 <submitted-url>$url</submitted-url>
                 <submitted-image-url>$imageUrl</submitted-image-url>
              </content>
              <visibility>
                 anyone
              </visibility>
            </share>";
        //echo $this->consumer;
        //echo "<br>at : ".$this->access_token."<br>";
        //echo "<b>".$access_token."</b>";
        $request = OAuthRequest::from_consumer_and_token($this->consumer, $access_token, "POST", $shareUrl);
        $request->sign_request($this->method, $this->consumer, $access_token);
        $auth_header = $request->to_header("https://api.linkedin.com");

        /*
          echo $xml . "\n";
          echo $auth_header . "\n";
         */
        //$auth_header = preg_replace("/Authorization\: OAuth\,/", "Authorization: OAuth ", $auth_header);
        //$auth_header = preg_replace('/\"\,/', '", ', $auth_header);


        $response = $this->httpRequest($shareUrl, $auth_header, "POST", $xml);
        /* echo $response; */
        return $response;
    }

    function httpRequest($url, $auth_header, $method, $body = NULL) {

        if (!$method) {
            $method = "GET";
        };

        //echo $url. " " .$method. " " .$body;
        //echo $auth_header;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header)); // Set the headers.
        //echo $auth_header;

        if ($body) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array($auth_header, "Content-Type: text/xml;charset=utf-8"));
        }

        $data = curl_exec($curl);
        //echo curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //if ($this->debug) {
        //echo "bla";
        //echo $data . "\n";
        //}

        curl_close($curl);

        return $data;
    }

}

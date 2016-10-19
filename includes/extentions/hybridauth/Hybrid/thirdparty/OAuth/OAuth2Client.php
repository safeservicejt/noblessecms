                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ame] = $this->access_token;
		$response = null;

		switch( $method ){
			case 'GET'  : $response = $this->request( $url, $parameters, "GET"  ); break;
			case 'POST' : $response = $this->request( $url, $parameters, "POST" ); break;
		}

		if( $response && $this->decode_json ){
			return $this->response = json_decode( $response );
		}

		return $this->response = $response;
	}

	/**
	 * Return the response object afer the fact
	 *
	 * @return mixed
	 */
	public function getResponse()
	{
	    return $this->response;
	}

	/**
	* GET wrapper for provider apis request
	*/
	function get( $url, $parameters = array() )
	{
		return $this->api( $url, 'GET', $parameters );
	}

	/**
	* POST wrapper for provider apis request
	*/
	function post( $url, $parameters = array() )
	{
		return $this->api( $url, 'POST', $parameters );
	}

	// -- tokens

	public function tokenInfo($accesstoken)
	{
		$params['access_token'] = $this->access_token;
		$response = $this->request( $this->token_info_url, $params );
		return $this->parseRequestResult( $response );
	}

	public function refreshToken( $parameters = array() )
	{
		$params = array(
			"client_id"     => $this->client_id,
			"client_secret" => $this->client_secret,
			"grant_type"    => "refresh_token"
		);

		foreach($parameters as $k=>$v ){
			$params[$k] = $v;
		}

		$response = $this->request( $this->token_url, $params, "POST" );
		return $this->parseRequestResult( $response );
	}

	// -- utilities

	private function request( $url, $params=false, $type="GET" )
	{
		Hybrid_Logger::info( "Enter OAuth2Client::request( $url )" );
		Hybrid_Logger::debug( "OAuth2Client::request(). dump request params: ", serialize( $params ) );

		if( $type == "GET" ){
			$url = $url . ( strpos( $url, '?' ) ? '&' : '?' ) . http_build_query($params, '', '&');
		}

		$this->http_info = array();
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL            , $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1 );
		curl_setopt($ch, CURLOPT_TIMEOUT        , $this->curl_time_out );
		curl_setopt($ch, CURLOPT_USERAGENT      , $this->curl_useragent );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , $this->curl_connect_time_out );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER , $this->curl_ssl_verifypeer );
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , $this->curl_ssl_verifyhost );
		curl_setopt($ch, CURLOPT_HTTPHEADER     , $this->curl_header );

		if($this->curl_proxy){
			curl_setopt( $ch, CURLOPT_PROXY        , $this->curl_proxy);
		}

		if( $type == "POST" ){
			curl_setopt($ch, CURLOPT_POST, 1);
			if($params) curl_setopt( $ch, CURLOPT_POSTFIELDS, $params );
		}

		$response = curl_exec($ch);
		if( $response === false ) {
				Hybrid_Logger::error( "OAuth2Client::request(). curl_exec error: ", curl_error($ch) );
		}
		Hybrid_Logger::debug( "OAuth2Client::request(). dump request info: ", serialize( curl_getinfo($ch) ) );
		Hybrid_Logger::debug( "OAuth2Client::request(). dump request result: ", serialize( $response ) );

		$this->http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$this->http_info = array_merge($this->http_info, curl_getinfo($ch));

		curl_close ($ch);

		return $response;
	}

	private function parseRequestResult( $result )
	{
		if( json_decode( $result ) ) return json_decode( $result );

		parse_str( $result, $output );

		$result = new StdClass();

		foreach( $output as $k => $v )
			$result->$k = $v;

		return $result;
	}
}

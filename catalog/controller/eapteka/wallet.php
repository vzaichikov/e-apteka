<?php

use Firebase\JWT\JWT;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Google\Client as Google_Client;

class ControllerEaptekaWallet extends Controller {
	private $jsonKey = '';

	/**
   * Path to service account key file from Google Cloud Console. Environment
   * variable: GOOGLE_APPLICATION_CREDENTIALS.
   */
	public string $keyFilePath;

  /**
   * Service account credentials for Google Wallet APIs.
   */
  public ServiceAccountCredentials $credentials;

  /**
   * Google Wallet service client.
   */
  public Google_Service_Walletobjects $service;

  public function __construct()
  {
  	$this->keyFilePath = GOOGLE_WALLET_JSON;
  }

  // [START auth]
  /**
   * Create authenticated HTTP client using a service account file.
   */
  public function auth()
  {
    $scope = 'https://www.googleapis.com/auth/wallet_object.issuer';

    $this->credentials = new ServiceAccountCredentials(
      $scope,
      $this->keyFilePath
    );

    // Initialize Google Wallet API service
    $this->client = new Google_Client();
    $this->client->setApplicationName('EAPTEKA_WALLET_SERVICE');
    $this->client->setScopes($scope);
    $this->client->setAuthConfig($this->keyFilePath);

    $this->service = new Google_Service_Walletobjects($this->client);
  }
  // [END auth]


  public function index(){
  	require_once(DIR_SYSTEM . 'library/Walletobjects.php');


  }


}
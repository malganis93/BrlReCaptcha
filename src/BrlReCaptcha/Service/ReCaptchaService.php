<?php
/**
 * Created by PhpStorm.
 * User: lars
 * Date: 18.03.15
 * Time: 00:30
 */

namespace BrlReCaptcha\Service;

use Zend\Http\Client as HttpClient;
use Zend\Http\Request as HttpRequest;
use Zend\Http\Response as HttpResponse;

/**
 * Class ReCaptchaService
 * @package BrlShort\ReCaptcha\Service
 */
class ReCaptchaService {

    /**
     *  The URL for to verify an Captcha
     */
    const VERIFY_SERVER = "https://www.google.com/recaptcha/api/siteverify";

    /**
     * @var String The secret-key from recaptcha
     */
    protected $privateKey = null;


    /**
     * @var String the public-key from recaptcha
     */
    protected $publicKey = null;


    /**
     * @var String Error code from request
     */
    protected $errorCode = null;

    /**
     * @param null $privateKey
     * @param null $publicKey
     */
    function __construct($privateKey = null, $publicKey=null)
    {
        $this->privateKey = $privateKey;
        $this->publicKey = $publicKey;
    }


    /**
     * @return null
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param null $privateKey
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;
    }

    /**
     * @return String
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param String $publicKey
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;
    }




    /**
     * @return String
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @param String $errorCode
     */
    public function setErrorCode($errorCode)
    {
        $this->errorCode = $errorCode;
    }


    /**
     * @param $clientResponse
     * @param null $ip
     * @return bool
     */
    public function verify($clientResponse, $ip = null) {

        //send the request to google recaptcha
        $request = $this->sendApiRequest($clientResponse, $ip);
        // and validate it
        return  $this->verifyApiResponse($request);

    }




    /**
     * @param $response
     * @param null $ip
     * @return HttpResponse
     */
    public function sendApiRequest($response, $ip = null)
    {
        $postParams = array(
            'secret' => $this->getPrivateKey(),
            'response' => $response
        );

        if ($ip) {
            $postParams['remoteip'] = $ip;
        }

        $httpClient = new HttpClient();

        $request = new HttpRequest();
        $request->setUri(self::VERIFY_SERVER);
        $request->setMethod(HttpRequest::METHOD_POST);
        $request->getPost()->fromArray($postParams);

        //$httpClient->setEncType($httpClient::ENC_URLENCODED);
        return $httpClient->send($request);
    }

    /**
     * @param HttpResponse $response
     * @return bool
     */
    public function verifyApiResponse(HttpResponse $response) {
        $body = $response->getBody();
        $content = json_decode($body,true);

        //get the status
        if ($content['success'] == true ) {
            return true;
        } else {

            //TODO: One or more codes at ones?
            $this->setErrorCode(implode(',', $content['error-codes']));
            return false;
        }

    }

}
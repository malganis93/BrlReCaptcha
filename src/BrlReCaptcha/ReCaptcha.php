<?php

/**
 * Created by PhpStorm.
 * User: lars
 * Date: 18.03.15
 * Time: 00:33.
 */
namespace BrlReCaptcha;

use Traversable;
use BrlReCaptcha\Service\ReCaptchaService;
use Zend\Captcha\AbstractAdapter;
use Zend\Validator\Exception;

/**
 * Class ReCaptcha.
 */
class ReCaptcha extends AbstractAdapter
{
    /**
     * @var \BrlReCaptcha\Service\ReCaptchaService
     */
    protected $service;

    /**#@+
     * Error codes
     */
    const MISSING_VALUE = 'missingValue';
    const BAD_CAPTCHA   = 'badCaptcha';
    /**#@-*/

    /**
     * Error messages.
     *
     * @var array
     */
    protected $messageTemplates = array(
        self::MISSING_VALUE => 'Missing captcha fields',
        self::BAD_CAPTCHA   => 'Captcha value is wrong. %value%',
    );

    /**
     * @return \BrlReCaptcha\Service\ReCaptchaService
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function setPrivkey($key)
    {
        $this->getService()->setPrivateKey($key);

        return $this;
    }

    /**
     * @return string
     */
    public function getPrivkey()
    {
        return $this->getService()->getPrivateKey();
    }

    /**
     * @param $key
     *
     * @return $this
     */
    public function setPubkey($key)
    {
        $this->getService()->setPublicKey($key);

        return $this;
    }

    /**
     * @return string
     */
    public function getPubkey()
    {
        return $this->getService()->getPublicKey();
    }


    /**
     * @param $theme
     * @return $this
     */
    public function setTheme($theme)
    {
        $this->getService()->setTheme($theme);

        return $this;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->getService()->getTheme();
    }

    /**
     * Constructor.
     *
     * @param null|array|Traversable $options
     */
    public function __construct($options = null)
    {
        $this->setService(new ReCaptchaService());

        parent::__construct($options);

        if (!empty($options)) {
            if (array_key_exists('private_key', $options)) {
                $this->getService()->setPrivateKey($options['private_key']);
            }
            if (array_key_exists('public_key', $options)) {
                $this->getService()->setPublicKey($options['public_key']);
            }

            if (array_key_exists('theme', $options)) {
                $this->getService()->setTheme($options['theme']);
            }
            $this->setOptions($options);
        }
    }

    /**
     * Generate a new captcha.
     *
     * @return string new captcha ID
     */
    public function generate()
    {
        //Method is in interface, but not required for recaptcha, since google handles the generation
        return '';
    }

    /**
     * Returns true if and only if $value meets the validation requirements.
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param mixed $value
     * @param mixed $context Param for ZF2.4
     *
     * @return bool
     *
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value, $context = null)
    {
        if (!$value) {
            $this->error(self::MISSING_VALUE);
        }

        $result = $this->getService()->verify($value);

        if (!$result) {
            $this->error(self::BAD_CAPTCHA, $this->getService()->getErrorCode());

            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getHelperName()
    {
        return 'browserlife/recaptcha';
    }
}

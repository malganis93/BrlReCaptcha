<?php

/**
 * Created by PhpStorm.
 * User: lars
 * Date: 18.03.15
 * Time: 00:43.
 */
namespace BrlReCaptcha\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormInput;

/**
 * Class ReCaptcha.
 */
class ReCaptcha extends FormInput
{
    /**
     * @param ElementInterface $element
     *
     * @return string|FormInput
     */
    public function __invoke(ElementInterface $element = null)
    {
        if (!$element) {
            return $this;
        }

        return $this->render($element);
    }

    /**
     * @param ElementInterface $element
     *
     * @return string
     */
    public function render(ElementInterface $element)
    {
        /** @var \BrlReCaptcha\ReCaptcha $captcha */
        $captcha = $element->getCaptcha();

        $pubkey = $captcha->getPubkey();

        $theme = $captcha->getTheme();

        $html = '<div class="g-recaptcha" data-sitekey="'.$pubkey.'" data-theme="'.$theme.'"></div>';
        //Add the js for the recaptcha api
        $this->view->headScript()->appendFile('https://www.google.com/recaptcha/api.js');

        return $html;
    }
}

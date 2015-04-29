<?php

/**
 * Created by PhpStorm.
 * User: lars
 * Date: 18.03.15
 * Time: 20:00.
 */

return array(

    'service_manager' => array(
        'invokeables' => array(
            'BrlReCaptcha\Service\ReCaptcha' => 'BrlReCaptcha\Service\ReCaptchaService',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'browserlife/recaptcha' => 'BrlReCaptcha\Helper\ReCaptcha',

        ),
    ),
);

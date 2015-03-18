# BrlReCaptcha - A ZF2 Module for Google ReCaptchaV2 # 
 
This modules makes it possible to use the new ReCaptcha [LINK](https://www.google.com/recaptcha) in your ZendFramework2 (ZF2) projects. 

I created this module, since [ZendFrameworkService\ReCaptcha](https://github.com/zendframework/ZendService_ReCaptcha) seems to be dead and is still on RCv1. 
## Installation 
TODO

## Get your private-key 
To use this service, you have to register at [Google ReCaptcha](https://www.google.com/recaptcha) using your Google-Account.

## Usage 
### with Zend\From
This module works similar as [ZendFrameworkService\ReCaptcha](https://github.com/zendframework/ZendService_ReCaptcha). 

Just add the following lines to your form creation:
```
$element = new \Zend\Captcha\Captcha('g-captcha-response');
$element->setCaptcha(new BrlReCaptcha\ReCaptcha(array('private_key' => 'YOUR_SECRET FROM GOOGLE', 'public_key' => 'YOUR_PUBLIC_KEY')));
$form->add($element);

```
Remember to add this element to your validationChain as well. 


It acts the same way as any other built-in captcha solution.
 
### with ServiceManager 
If you like to implement the view on your own, just use the Service\ReCaptchaService. It handles the whole communication between your code and the ReCaptcha API. 

```
$recaptcha = $serviceLocator->get('BrlRecaptcha\Service\ReCaptcha');

```

### other 

just look into the sources! It's pretty easy to understand.


## TODO  
* PHPUnit Tests are missing -> Will do this in the next couple of days
* some error handling is qnd
* better documentation 

## Questions? 
If you have any problems or questions regarding my code, please create an issue.
Since i'm using this module for my own projects i'm interested in keeping this up to date! 

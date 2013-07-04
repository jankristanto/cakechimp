Cakechimp-Plugin
========================

CakePHP Mailchimp Plugin to use the API in a CakePHP way.

<b>Getting Started</b><br />

1) Open your file bootstrap.php
2) Add the following: 

CakePlugin::load('cakechimp');

3) Load the component in the Controller. 

4) Fill out the settings in the Config folder located inside Plugin/Mailchimp 

Use as follows:

$this->Mailchimp->listSubscribe($limit);

5) lots of functions not available yet. You are free to write from the Mailchimp API and import them to the Component - it is VERY easy to do so!
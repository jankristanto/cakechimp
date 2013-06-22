<?php

/**
 * MailchimpComponent
 *
 * @author : Jan Kristanto 
 */
class MailchimpComponent extends Component {

	public $chimp;
  /**
   * Constructor merge settings
   * 
   * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
   * @param array $settings Array of configuration settings.
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    parent::__construct($collection, $settings);
  }
  
  /**
   * Initialization method. Triggered before the controller's `beforeFilfer`
   * method but after the model instantiation.
   *
   * @param Controller $controller
   * @param array $settings
   * @return null
   * @access public
   */
  public function initialize(Controller $controller) {
    // Handle loading our library firstly...
    App::build(array('Vendor' => array(
      APP.DS .'Vendor'.DS)
    ));    
    App::import('Vendor', 'Mailchimp', array(
      'file' => 'mailchimp'.DS.'examples'.DS.'inc'.DS.'MCAPI.class.php'
    ));
	App::import('Vendor', 'Mailchimp', array(
      'file' => 'mailchimp'.DS.'examples'.DS.'inc'.DS.'config.inc.php'
    ));
	$this->chimp = new MCAPI(Configure::read('config_admin_codes.Mailchimp.api'));
  }
  
  public function listMembers(){
	$retval = $this->chimp->listMembers(Configure::read('config_admin_codes.Mailchimp.listId'), 'subscribed', null, 0, Configure::read('config_admin_codes.Mailchimp.limit') );
	
	return $retval;
  }
  
  public function subscribe($email,$fname,$lname){
	$merge_vars = array('FNAME'=>$fname, 'LNAME'=>$lname);
	$retval = $this->chimp->listSubscribe(Configure::read('config_admin_codes.Mailchimp.listId'), $email, $merge_vars );
	return $this->chimp->errorCode;
  }

  
}
<?php
/**
* MailchimpComponent
*
* @author : Jan Kristanto 
*/
Configure::load('cakechimp.Mailchimp');
class MailchimpComponent extends Component {
	public $chimp;
	public $listId;
	public $api;
	/**
	* Constructor merge settings
	* 
	* @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
	* @param array $settings Array of configuration settings.
	*/
	public function __construct(ComponentCollection $collection, $settings = array()) {
		$this->api = Configure::read('Mailchimp.api');
		$this->listId = Configure::read('Mailchimp.listId');
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
		  APP.DS.'Plugin'. DS . 'cakechimp' .DS.'Vendor'.DS)
		));    
		
		App::import('Vendor', 'Mailchimp', array(
		  'file' => 'mailchimp'.DS.'examples'.DS.'inc'.DS.'MCAPI.class.php'
		));
		App::import('Vendor', 'Mailchimp', array(
		  'file' => 'mailchimp'.DS.'examples'.DS.'inc'.DS.'config.inc.php'
		));
		$this->chimp = new MCAPI($this->api);
	}

	public function listMembers($limit){
		$retval = $this->chimp->listMembers($this->listId, 'subscribed', null, 0, $limit);
		return $retval;
	}

	public function listMemberInfo($emails){
		$retval = $this->chimp->listMemberInfo($this->listId, $emails);
		return $retval;
	}
	
	public function subscribe($email,$fname,$lname){
		$merge_vars = array('FNAME'=>$fname, 'LNAME'=>$lname);
		$retval = $this->chimp->listSubscribe($this->listId, $email, $merge_vars );
		return $this->chimp->errorCode;
	}

	
}
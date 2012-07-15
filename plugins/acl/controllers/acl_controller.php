<?php

class AclController extends AclAppController {
	var $name = 'Acl';

	var $uses = array('Acl.AclAco', 'Acl.AclAro');

	var $helpers = array('Html', 'Javascript');
	
	var $components = array('Acl');

	function webadm_index() {
//Allow warriors complete access to weapons
//Both these examples use the alias syntax
$this->Acl->allow('warriors', 'Weapons');
//Though the King may not want to let everyone
//have unfettered access
$this->Acl->deny('warriors/Legolas', 'Weapons', 'delete');
$this->Acl->deny('warriors/Gimli', 'Weapons', 'delete');

$this->Acl->allow('warriors', 'Weapons.list');


	
		echo 'acl:'.$this->Acl->check('warriors/Legolas', 'Weapons','delete');
	}

	function webadm_aros() {

	}

	function webadm_acos() {

	}

	function webadm_permissions() {

	}

}

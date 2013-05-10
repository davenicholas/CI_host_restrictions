<?php

$config['host_restrictions'] = array (
	
	//you can name the rulesets anything you like
	'name_of_a_rule_set' =>
		array(
			'1.1.1.*', //wild carded ipaddress
			'2.2.2.2-20', //ipaddress range
			'3.3.3.3', //absolute ipaddress
			),

	'another_random_ruleset' =>
		array(
			'1.2.3.4',
		),
);
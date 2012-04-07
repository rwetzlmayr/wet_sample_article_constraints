<?php
class wet_sample_article_constraints
{
	function __construct()
	{
		register_callback(__CLASS__.'_ignore_status', 'article_ui', 'validate_save');
		register_callback(__CLASS__.'_min_title_length', 'article_ui', 'validate_save');
	}
}

/**
 * Constrain minimum title length
 */
class wet_TitleLengthConstraint extends Constraint
{
	function validate()
	{
		return mb_strlen($this->value) >= $this->options['min'];
	}
}

/**
 * Establish custom constraints
 */
function wet_sample_article_constraints_ignore_status($event, $step, &$rs, &$constraints)
{
	// release constraints on allowed status values
	unset($constraints['Status']);
}

function wet_sample_article_constraints_min_title_length($event, $step, &$rs, &$constraints)
{
	// Add a custom constraint to enforce a title length of 5 characters or more
	$constraints['wet_titlelength'] = new wet_TitleLengthConstraint($rs['Title'], array('min' => 5, 'message' => 'title_too_short'));
}

if (txpinterface == 'admin') new wet_sample_article_constraints;

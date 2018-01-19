<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class PageValidator.
 *
 * @package namespace App\Validators;
 */
class PageValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'mnemonic' => 'required',
            'header' => 'min:3',
            'content' => 'min:3'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'mnemonic' => 'required',
            'header' => 'min:3',
            'content' => 'min:3'
        ]
    ];
}

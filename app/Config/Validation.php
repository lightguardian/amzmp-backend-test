<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
    //--------------------------------------------------------------------
    // Setup
    //--------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var string[]
     */
    public $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    public $fiscalCustomerCreate = [
        'creator_user' => 'required|is_not_unique[user.id]|integer',
        'cnpj' => 'required|exact_length[14]',
        'corporate_name' => 'required|min_length[3]',
        'trade_name' => 'required',
    ];

    public $fiscalCustomerUpdate = [
        'cnpj' => 'permit_empty|exact_length[14]|integer',
        'corporate_name' => 'permit_empty|min_length[3]',
    ];

    public $userCreate = [
        'name' => 'required|min_length[3]',
        'email' => 'required|valid_email',
        'password' => 'required'
    ];

    public $userLogin = [
        'email' => 'required',
        'password' => 'required'
    ];

    public $fiscalCustomerExists = [
        'id' => 'required|is_not_unique[fiscal_customer.id]|integer',
    ];
}

<?php namespace Config;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var array
	 */
	public $ruleSets = [
		\CodeIgniter\Validation\Rules::class,
		\CodeIgniter\Validation\FormatRules::class,
		\CodeIgniter\Validation\FileRules::class,
		\CodeIgniter\Validation\CreditCardRules::class,
	];

	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

    //--------------------------------------------------------------------
    // Rules
    //--------------------------------------------------------------------

    /**
     * This rules will be used in App\Controllers\Admin\Project.
     *
     * @var array
     */
    public array $projectRules = [
        'name' => [
            'label' => 'admin.project.form.name.name',
            'rules' => 'required|alpha_numeric_space|max_length[50]',
            'errors' => [
                'required' => 'admin.project.form.name.validation.required',
                'alpha_numeric_space' => 'admin.project.form.name.validation.alpha_numeric_space',
                'max_length' => 'admin.project.form.name.validation.max_length'
            ]
        ],
        'description' => [
            'label' => 'admin.project.form.description.name',
            'rules' => 'required|alpha_numeric_space|max_length[500]',
            'errors' => [
                'required' => 'admin.project.form.description.validation.required',
                'alpha_numeric_space' => 'admin.project.form.description.validation.alpha_numeric_space',
                'max_length' => 'admin.project.form.description.validation.max_length'
            ]
        ]
    ];

    /**
     * This rules will be used in App\Controllers\Admin\Role.
     *
     * @var array
     */
    public array $roleRules = [
        'name' => [
            'label' => 'role.form.name.name',
            'rules' => 'required|alpha_numeric_space',
            'errors' => [
                'required' => 'role.form.name.validation.required',
                'alpha_numeric_space' => 'role.form.name.validation.alpha_numeric_space',
            ]
        ]
    ];

    /**
     * This rules will be used in App\Controllers\Project\Admin\TicketFields.
     *
     * @var array
     */
    public array $projectTicketFieldsRules = [
        'identification' => [
            'label' => 'project.form.ticketFields.identification.name',
            'rules' => 'required|alpha_numeric_space|max_length[50]',
            'errors' => [
                'required' => 'project.form.ticketFields.identification.validation.required',
                'alpha_numeric_space' => 'project.form.ticketFields.identification.validation.alpha_numeric_space',
                'max_length' => 'project.form.ticketFields.identification.validation.max_length',
            ]
        ],
        'name' => [
            'label' => 'project.form.ticketFields.name.name',
            'rules' => 'required|alpha_numeric_punct|max_length[50]',
            'errors' => [
                'required' => 'project.form.ticketFields.name.validation.required',
                'alpha_numeric_punct' => 'project.form.ticketFields.name.validation.alpha_numeric_punct',
                'max_length' => 'project.form.ticketFields.name.validation.max_length'
            ]
        ],
        'type' => [
            'label' => 'project.form.ticketFields.type.name',
            'rules' => 'required',
            'errors' => [
                'required' => 'project.form.ticketFields.type.validation.required',
                'in_list' => 'project.form.ticketFields.type.validation.in_list'
            ]
        ],
        'description' => [
            'label' => 'project.form.ticketFields.description.name',
            'rules' => 'required|alpha_numeric_space|max_length[250]',
            'errors' => [
                'required' => 'project.form.ticketFields.description.validation.required',
                'alpha_numeric_space' => 'project.form.ticketFields.description.validation.alpha_numeric_space',
                'max_length' => 'project.form.ticketFields.description.validation.max_length'
            ]
        ],
        'required' => [
            'label' => 'project.form.ticketFields.required.name',
            'rules' => 'required',
            'errors' => [
                'required' => 'project.form.ticketFields.required.validation.required'
            ]
        ]
    ];

    /**
     * This rules will be used in App\Controllers\Project\Admin\TicketStatus.
     *
     * @var array
     */
    public array $projectTicketStatusRules = [
        'name' => [
            'label' => 'project.form.ticketStatus.name.name',
            'rules' => 'required|alpha_numeric_space|max_length[50]',
            'errors' => [
                'required' => 'project.form.ticketStatus.name.validation.required',
                'alpha_numeric_space' => 'project.form.ticketStatus.name.validation.alpha_numeric_space',
                'max_length' => 'project.form.ticketStatus.name.validation.max_length',
            ]
        ],
        'priority' => [
            'label' => 'project.form.ticketStatus.priority.name',
            'rules' => 'required|numeric',
            'errors' => [
                'required' => 'project.form.ticketStatus.priority.validation.required',
                'numeric' => 'project.form.ticketStatus.priority.validation.numeric'
            ]
        ]
    ];

    /**
     * This rules will be used in App\Controllers\Project\Admin\TicketType.
     *
     * @var array
     */
    public array $projectTicketTypeRules = [
        'name' => [
            'label' => 'project.form.ticketType.name.name',
            'rules' => 'required|alpha_numeric_space|max_length[50]',
            'errors' => [
                'required' => 'project.form.ticketType.name.validation.required',
                'alpha_numeric_space' => 'project.form.ticketType.name.validation.alpha_numeric_space',
                'max_length' => 'project.form.ticketType.name.validation.max_length',
            ]
        ]
    ];
}

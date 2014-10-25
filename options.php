<?php 
class GAuthorizedUserOnlyOptions
{
	private $options;
    private $error = array();

    public function __construct()
	{
		add_action('admin_menu', array($this,'add_plugin_page'));
		add_action('admin_init', array($this,'page_init'));
	}

	public function add_plugin_page()
	{
		add_options_page(
            'Settings Admin',
            'G Authorized User Only Settings',
            'manage_options',
            'g-authorized-user-only-admin',
            array($this, 'create_admin_page')
		);
	}

	public function create_admin_page()
	{
        $this->options = get_option('g_authorized_user_only_option_name');

    }

   public function page_init()
    {

        if(!current_user_can('administrator')) return ;
    	register_setting(
			'sba_app_option_group',
            'sba_app_option_name',
            array($this,'sanitize')
		);


        add_settings_section(
            'g_authorized_user_only_section',
            'Not logged in user redirect url',
            array($this,'print_section_info'),
            'g-authorized-user-only-admin'
        );


        add_settings_field(
            'g_authorized_user_only_redirect_url_option',
            'Not logged in user redirect url',
            array($this,'g_authorized_user_only_redirect_url_option_callback'),
            'g-authorized-user-only-admin',
            'g_authorized_user_only_section',
        );
	}

    public function print_section_info()
    {
        echo 'Configuration';
    }

    public function g_authorized_user_only_redirect_url_option_callback()
    {
        printf('<input type="text" id="acls_context" name="sba_app_option_name[acls_context]" value="%s" />',
            isset($this->options['acls_context'])?
            esc_attr($this->options['acls_context']):'');  
        printf('<input type="text" id="acls_context" name="sba_app_option_name[acls_context]" value="%s" />',
            isset($this->options['acls_context'])?
            esc_attr($this->options['acls_context']):'');  
    }

	public function sanitize($input)
	{
		return $input;
	}
}

if(is_admin())
	$options  = new GAuthorizedUserOnlyOptions();

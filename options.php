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
        $this->options = get_option('g_authorized_user_only_redirect_url');
        ?>
        <div class="wrap">
            <h2>Sba App Config</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields('g_authorized_user_only_option_group');
                do_settings_sections('g-authorized-user-only-admin');
                submit_button(); 
                ?>
            </form>
        </div>
        <?php
    }

   public function page_init()
    {

        if(!current_user_can('administrator')) return ;
    	register_setting(
			'g_authorized_user_only_option_group',
            'g_authorized_user_only_option',
            array($this,'sanitize')
		);


        add_settings_section(
            'g_authorized_user_only_section',
            'URL settings',
            array($this,'print_section_info'),
            'g-authorized-user-only-admin'
        );


        add_settings_field(
            'g_authorized_user_only_redirect_url',
            'Not logged in user redirect url',
            array($this,'g_authorized_user_only_redirect_url_callback'),
            'g-authorized-user-only-admin',
            'g_authorized_user_only_section'
        );
	}

    public function print_section_info()
    {
        echo 'Configuration';
    }

    public function g_authorized_user_only_redirect_url_callback()
    {
        printf('<input type="text" id="g_authorized_user_only_redirect_url" name="g_authorized_user_only_redirect_url" value="%s" />',
            isset($this->options['g_authorized_user_only_redirect_url'])?
            esc_attr($this->options['g_authorized_user_only_redirect_url']):'');  
    }

	public function sanitize($input)
	{
		return $input;
	}
}

if(is_admin())
	$options  = new GAuthorizedUserOnlyOptions();

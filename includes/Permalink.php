<?php


class oFim_Permalink
{


    public function __construct()
    {


    }
    public function register(){
        add_action('admin_init', array( $this, 'settingsInit'));
        add_action('admin_init', array( $this, 'settingsSave'));
    }


    public function settingsInit() {
        $this->addField('', array($this, 'slug_title'), '');
        $this->addField('ophim_slug_movie', array( $this, 'ophim_movie'), 'Movie' );
        $this->addField('ophim_slug_directors', array( $this, 'ophim_directors'), 'Directors' );
        $this->addField('ophim_slug_categories', array( $this, 'ophim_categories'), 'Categories' );
        $this->addField('ophim_slug_actors', array( $this, 'ophim_actors'), 'Actors' );
        $this->addField('ophim_slug_genres', array( $this, 'ophim_genres'), 'Genres' );
        $this->addField('ophim_slug_regions', array( $this, 'ophim_regions'), 'Regions' );
        $this->addField('ophim_slug_tags', array( $this, 'ophim_tags'), 'Tags' );
        $this->addField('ophim_slug_years', array( $this, 'ophim_years'), 'Years' );
    }

    /* Callbacks
	-------------------------------------------------------------------------------
	*/
    public function slug_title() {
        echo '<h3 id="dooplay-permalinks">OPhim Permalink Settings</h3>';
    }

    public function ophim_directors() {
        echo $this->input('ophim_slug_directors', 'directors', '/benal-tairi/');
    }
    public function ophim_movie() {
        echo $this->input('ophim_slug_movies', 'movie', '/nang-tien-ca/');
    }
    public function ophim_categories() {
        echo $this->input('ophim_slug_categories', 'categories', '/phim-cu/');
    }
    public function ophim_actors() {
        echo $this->input('ophim_slug_actors', 'actors', '/khanh-phuong/');
    }
    public function ophim_genres() {
        echo $this->input('ophim_slug_genres', 'genres', '/kinh-di/');
    }
    public function ophim_regions() {
        echo $this->input('ophim_slug_regions', 'regions', '/quoc-gia/');
    }
    public function ophim_tags() {
        echo $this->input('ophim_slug_tags', 'tags', '/lien-quan/');
    }
    public function ophim_years() {
        echo $this->input('ophim_slug_years', 'years', '/nam/');
    }


    public function settingsSave() {
        if ( ! is_admin() ) return;
        $this->saveField('ophim_slug_directors');
        $this->saveField('ophim_slug_movies');
        $this->saveField('ophim_slug_categories');
        $this->saveField('ophim_slug_actors');
        $this->saveField('ophim_slug_genres');
        $this->saveField('ophim_slug_tags');
        $this->saveField('ophim_slug_years');
        $this->saveField('ophim_slug_regions');
    }


    public function input( $option_name, $placeholder = '', $type ) {
        $slug = get_option( $option_name );
        $value = ( isset( $slug ) ) ? esc_attr( $slug ) : '';
        $utype = ($type) ? '<code>'. $type .'</code>' : null;

        return '<code>'. home_url() .'/</code><input class="dt_permaliks_input" name="'. $option_name .'" type="text" class="regular-text code" value="'. $slug .'" placeholder="'. $placeholder .'" />'. $utype;
    }

    public function addField( $option_name, $callback, $title ){
        add_settings_field(
            $option_name, // id
            $title,       // setting title
            $callback,    // display callback
            'permalink',  // settings page
            'optional'    // settings section
        );
    }
    public function saveField( $option_name ){
        if ( isset( $_POST[$option_name] ) ) {
            $permalink_structure = sanitize_title( $_POST[$option_name] );
            $permalink_structure = untrailingslashit( $permalink_structure );

            update_option( $option_name, $permalink_structure );
        }
    }


}
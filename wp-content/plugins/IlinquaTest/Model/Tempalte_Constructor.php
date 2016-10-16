<?php
/**
 * Created by PhpStorm.
 * User: icefier
 * Date: 16.10.16
 * Time: 12:01
 */

namespace IlinquaTest\Model;


class Tempalte_Constructor
{


    /**
     * templates for plugins
     */
    protected $_templates;


    /**
     * Tempalte_Constructor constructor.
     * @param array $templates
     */
    public function __construct(array $templates)
    {

        $this->templates = $templates;
        add_filter(
            'page_attributes_dropdown_pages_args',
            [$this, 'register_project_templates']
        );
        add_filter(
            'wp_insert_post_data',
            [$this, 'register_project_templates']
        );

        add_filter(
            'template_include',
            [ $this, 'view_project_template']
        );
    }

    /**
     * Adds our template to the pages cache in order to trick WordPress
     * into thinking the template file exists where it doens't really exist.
     *
     */

    public function register_project_templates()
    {
        $cacheKey = 'page_templates-' .
            md5(get_theme_root() . '/' . get_stylesheet());
        $templates = wp_get_theme()->get_page_templates();
        if (empty($templates)) {
            $templates = [];
        }
        wp_cache_delete($cacheKey, 'themes');
        $templates = array_merge(
            $templates, $this->templates
        );
        wp_cache_add(
            $cacheKey, $templates, 'themes', 1800
        );

        return true;
    }

    /**
     * Checks if the template is assigned to the page
     */
    public function view_project_template( $template )
    {

        global $post;

        if (! $post) {
            return $template;
        }

        // Return default template if we don't have a custom one defined
        if (!isset( $this->templates[get_post_meta(
                $post->ID, '_wp_page_template', true
            )])) {
            return $template;
        }

        $file = plugin_dir_path(__FILE__). get_post_meta(
                $post->ID, '_wp_page_template', true
            );

        // Just to be safe, we check if the file exist first
        if ( file_exists( $file ) ) {
            return $file;
        } else {
            echo $file;
        }

        // Return template
        return $template;

    }

}

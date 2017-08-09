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
     * @var $_templateDir  - path to template render.
     */
    protected $_templateDir;

    /**
     * Tempalte_Constructor constructor.
     * @param array $templates
     */
    public function __construct(array $templates)
    {
        $this->_templateDir = TEMPLATE_PATH_TEST . '/page-templates/';

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
        add_filter(
            'single_template',
            [ $this, 'view_single_template']
        );
        return $templates;
    }

    /**
     * Add template to the cache
     * @param $atts
     * @return mixed
     */

    public function register_project_templates($atts)
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

        return $atts;
    }

    /**
     * render template
     * @param $template
     * @return string
     */
    public function view_project_template($template)
    {
        global $post;

        if (!$post) {
            return $template;
        }

        // Return default template if we don't have a custom one defined
        if (!isset(
            $this->templates[
            get_post_meta($post->ID, '_wp_page_template', true)
            ]
        )) {
            return $template;
        }

        $file = $this->_templateDir .
            get_post_meta($post->ID, '_wp_page_template', true) . '.php';

        if (file_exists($file)) {
            return $file;
        }

        return $template;

    }

    /**
     * TODO::Now it works only for post type test. Update to work correctly.
     * This set view for plugin templates
     * @param $single
     * @return string
     */
    public function view_single_template($single)
    {
        global $post;
        if ($post->post_type == "test") {
            if(file_exists($this->_templateDir. '/test.php'))
                return  $this->_templateDir. '/test.php';
        }
        return $single;
    }

}

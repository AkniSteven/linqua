<?php
namespace ilinqua\app\Helper;

class Data
{
    /**
     * @param $string
     * @param string $allow
     * @return string
     * Function for clear text from text
     */
    public static function cleanString($string, $allow='')
    {
        return trim(strip_tags($string, $allow));
    }

    /**
     * @param $attachment_id
     * @return mixed
     * Return attachment images
     */
    public static function getAttachmentMeta($attachment_id)
    {
        $alt = get_post_meta(
            $attachment_id, '_wp_attachment_image_alt', true
        );
        if ($alt == '') {
            $alt = explode(
                '.', basename(get_attached_file($attachment_id)))[0];
        }
        return $alt;
    }

    /**
     * Return term Ids
     * @param $post
     * @param string $taxonomyName
     * @return array
     */
    public static function getPostTermIds($post, $taxonomyName="category")
    {
        $termIds = [];

        $postTerms = get_the_terms($post, $taxonomyName);
        if (!empty($postTerms)) {
            foreach ($postTerms as $term) {
                $termIds[] = $term->term_id;
            }
        }
        return $termIds;
    }

    public static function getTermPermalink($term, $taxonomyName )
    {
        return get_term_link($term,$taxonomyName); 
    }

    public static function getUserRole()
    {
        global $wp_roles;
        $currentUser = wp_get_current_user();
        $roles = $currentUser->roles;
        $role = array_shift($roles);
        return $wp_roles->role_names[$role];
    }

}
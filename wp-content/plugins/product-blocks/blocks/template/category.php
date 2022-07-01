<?php
defined('ABSPATH') || exit;

$category = '';
if ($attr['catShow']) {
    $category .= '<div class="wopb-category-grid wopb-category-'.esc_attr($attr['catPosition']).'">';
        $category .= '<div class="wopb-category-in">';
            $cat = get_the_terms($post_id, 'product_cat');
            if (!empty($cat)) {
                foreach ($cat as $val) {
                    $category .= '<a href="'.esc_url(get_term_link($val->term_id)).'">'.esc_html($val->name).'</a>';
                }
            }
        $category .= '</div>';
    $category .= '</div>';
}
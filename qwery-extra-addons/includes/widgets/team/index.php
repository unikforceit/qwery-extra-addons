<?php

namespace Elementor;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class qwery_extra_addon_team extends Widget_Base
{

    public function get_name()
    {
        return 'qwery-extra-addon-team';
    }

    public function get_title()
    {
        return __('Team Modern', 'qwery');
    }

    public function get_categories()
    {
        return ['trx_addons-cpt'];
    }

    public function get_icon()
    {
        return 'eicon-person';
    }

    protected function _register_controls()
    {

        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Team', 'qwery'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'query_type',
            [
                'label' => __('Query type', 'qwery'),
                'type' => Controls_Manager::SELECT,
                'default' => 'individual',
                'options' => [
                    'category' => __('Category', 'qwery'),
                    'individual' => __('Individual', 'qwery'),
                ],
            ]
        );

        $this->add_control(
            'cat_query',
            [
                'label' => __('Category', 'qwery'),
                'type' => Controls_Manager::SELECT2,
                'options' => qwery_drop_cat('cpt_team_group'),
                'multiple' => true,
                'label_block' => true,
                'condition' => [
                    'query_type' => 'category',
                ],
            ]
        );

        $this->add_control(
            'id_query',
            [
                'label' => __('Posts', 'qwery'),
                'type' => Controls_Manager::SELECT2,
                'options' => qwery_drop_posts('cpt_team'),
                'multiple' => true,
                'label_block' => true,
                'condition' => [
                    'query_type' => 'individual',
                ],
            ]
        );
        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'qwery'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );
        $this->add_control(
            'grid',
            [
                'label' => __('Grid', 'qwery'),
                'type' => Controls_Manager::NUMBER,
                'default' => 3,
            ]
        );
        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if ($settings['query_type'] == 'category') {
            $query_args = array(
                'post_type' => 'cpt_team',
                'posts_per_page' => $settings['posts_per_page'],
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cpt_team_group',
                        'field' => 'term_id',
                        'terms' => $settings['cat_query'],
                    ),
                ),
            );
        }

        if ($settings['query_type'] == 'individual') {
            $query_args = array(
                'post_type' => 'cpt_team',
                'posts_per_page' => $settings['posts_per_page'],
                'post__in' => $settings['id_query'],
                'orderby' => 'post__in'
            );
        }

        $wp_query = new \WP_Query($query_args);

        ?>
        <div class="sc_team sc_team_default qwery-extra-addon-team">
            <div class="sc_team_columns_wrap sc_item_columns sc_item_posts_container trx_addons_columns_wrap columns_padding_bottom columns_in_single_row">
                <?php
                if ($wp_query->have_posts()) {
                    while ($wp_query->have_posts()) {
                        $wp_query->the_post();
                        $meta = get_post_meta(get_the_ID(), 'trx_addons_options', true);
                        ?>
                        <div class="trx_addons_column-1_<?php echo esc_attr($settings['grid']) ?>">
                            <div class="sc_team_item sc_item_container">
                                <?php if (has_post_thumbnail()) { ?>
                                    <div class="post_featured with_thumb hover_link sc_team_item_thumb">
                                        <div class="sc_team_thumbs">
                                            <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('full'); ?></a>
                                        </div>
                                        <div class="sc_team_item_thumb_hover">
                                            <div class="sc_team_breif_meta">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php echo esc_html($meta['brief_info']) ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="sc_team_item_info">
                                    <div class="sc_team_item_header">
                                        <h4 class="sc_team_item_title entry-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                        <div class="sc_team_item_subtitle"><?php echo esc_html($meta['subtitle']) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>

    <?php }

    protected function content_template()
    {
    }

    public function render_plain_content($instance = [])
    {
    }

}

Plugin::instance()->widgets_manager->register_widget_type(new qwery_extra_addon_team());
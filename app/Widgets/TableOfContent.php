<?php

namespace SuperDocs\App\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use SuperDocs\Bootstrap\Utils;

class TableOfContent extends Widget_Base
{
    public function get_name()
    {
        return 'superdocs-table-of-content';
    }

    public function get_title()
    {
        return esc_html__( 'Table of Content', 'superdocs' );
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_categories()
    {
        return ['superdocs'];
    }

    public function get_keywords()
    {
        return ['superdocs', 'doc', 'content', 'knowledge base'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__( 'Content', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'table_of_content_heading_title',
            [
                'label'       => esc_html__( 'Heading Title', 'superdocs' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Table of Content'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_heading_style',
            [
                'label' => esc_html__( 'Heading Title', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'table_of_content_heading_title_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#4f46e5',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-table-of-content h4' => 'background-color: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_control(
            'table_of_content_heading_title_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-table-of-content h4' => 'color: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_responsive_control(
            'table_of_content_heading_title_padding',
            [
                'label'      => esc_html__( 'Padding (px)', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '8',
                    'right'    => '20',
                    'bottom'   => '8',
                    'left'     => '20',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-table-of-content h4' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );

        $this->add_responsive_control(
            'table_of_content_heading_title_margin',
            [
                'label'      => esc_html__( 'Margin (px)', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-table-of-content h4' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'table_of_content_heading_title_typography',
                'label'          => esc_html__( 'Typography', 'superdocs' ),
                'selector'       => '{{WRAPPER}} .superdocs-table-of-content h4',
                'exclude'        => ['font_style', 'letter_spacing'],
                'fields_options' => [
                    'typography'     => [
                        'default' => 'custom'
                    ],
                    'font_size'      => [
                        'label'      => esc_html__( 'Font Size (px)', 'superdocs' ),
                        'default'    => [
                            'size' => '14',
                            'unit' => 'px'
                        ],
                        'size_units' => ['px']
                    ],
                    'text_transform' => [
                        'default' => 'uppercase'
                    ],
                    'font_weight'    => [
                        'default' => '600'
                    ],
                    'line_height'    => [
                        'label'      => esc_html__( 'Line Height (px)', 'superdocs' ),
                        'default'    => [
                            'size' => '17',
                            'unit' => 'px'
                        ],
                        'size_units' => ['px']
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_list_style',
            [
                'label' => esc_html__( 'Content List', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'table_of_content_list_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#E5E5E6',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-table-of-content .content-list' => 'background-color: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_control(
            'table_of_content_list_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#2C2B2D',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-table-of-content li' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .superdocs-table-of-content a'  => 'color: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_responsive_control(
            'table_of_content_list_padding',
            [
                'label'      => esc_html__( 'Padding (px)', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '15',
                    'right'    => '15',
                    'bottom'   => '15',
                    'left'     => '42',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-table-of-content .content-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'table_of_content_list_typography',
                'label'          => esc_html__( 'Typography', 'superdocs' ),
                'selector'       => '{{WRAPPER}} .superdocs-table-of-content li',
                'exclude'        => ['font_style', 'letter_spacing'],
                'fields_options' => [
                    'typography'     => [
                        'default' => 'custom'
                    ],
                    'font_size'      => [
                        'label'      => esc_html__( 'Font Size (px)', 'superdocs' ),
                        'default'    => [
                            'size' => '16',
                            'unit' => 'px'
                        ],
                        'size_units' => ['px']
                    ],
                    'text_transform' => [
                        'default' => 'capitalize'
                    ],
                    'font_weight'    => [
                        'default' => '500'
                    ],
                    'line_height'    => [
                        'label'      => esc_html__( 'Line Height (px)', 'superdocs' ),
                        'default'    => [
                            'size' => '24',
                            'unit' => 'px'
                        ],
                        'size_units' => ['px']
                    ],
                    'text_decoration' => [
                        'default' => 'underline'
                    ]
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings         = $this->get_settings_for_display();
        $elementor        = \Elementor\Plugin::$instance;
        $general_settings = superdocs_general_settings();
        ?>
        <div class="superdocs">
            <div class="superdocs-table-of-content" data-allowed_heading="<?php wp_commander_render(Utils::json_encode_for_attr($general_settings['toc_supported_heading_tag']['value'])) ?>">
                <h4><?php wp_commander_render( $settings['table_of_content_heading_title'] )?></h4>
                <div class="content-list">
            <?php if ( $elementor->editor->is_edit_mode() || is_preview() ) {?>
                    <ol style="margin: 0;">
                        <li><a href="">Demo Content</a></li>
                        <li><a href="">Demo Content</a></li>
                        <li><a href="">Demo Content</a></li>
                    </ol>
                    <?php } else {?>
                    <ol style="margin: 0;"></ol>
                    <?php }?>
                </div>
            </div>
        </div>
        <?php
    }
}

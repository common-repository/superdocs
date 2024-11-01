<?php

namespace SuperDocs\App\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Search extends Widget_Base
{
    public function get_name()
    {
        return 'superdocs-search';
    }

    public function get_title()
    {
        return esc_html__( 'Search', 'superdocs' );
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
        return ['superdocs', 'doc', 'content', 'knowledge base', 'search'];
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
            'doc_search_all_product',
            [
                'label'       => esc_html__( 'All products title', 'superdocs' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'All Products'
            ]
        );

        $this->add_control(
            'doc_search_button_text',
            [
                'label'       => esc_html__( 'Button title', 'superdocs' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'Search'
            ]
        );

        $this->add_control(
            'doc_search_not_found_text',
            [
                'label'       => esc_html__( 'Not found text', 'superdocs' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => 'No Documentation found'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_products_style',
            [
                'label' => esc_html__( 'Products', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'doc_search_product_height',
            [
                'label'      => esc_html__( 'Height (px)', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 50
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .product' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_product_width',
            [
                'label'      => esc_html__( 'Width', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    '%' => [
                        'min'  => 5,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 20
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .product' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_product_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#f1f5f9',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .product select' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_product_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .product select' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'doc_search_product_padding',
            [
                'label'      => esc_html__( 'Padding (px)', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '0',
                    'right'    => '0',
                    'bottom'   => '0',
                    'left'     => '25',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .product select' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'doc_search_product_border',
                'selector'       => '{{WRAPPER}} .search-inputs .product select',
                'size_units'     => ['px'],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid'
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '2',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '2',
                            'isLinked' => false
                        ]
                    ],
                    'color'  => [
                        'default' => '#D4D4D4'
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'doc_search_product_typography',
                'label'          => esc_html__( 'Typography', 'superdocs' ),
                'selector'       => '{{WRAPPER}} .search-inputs select',
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
            'section_search_style',
            [
                'label' => esc_html__( 'Search', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'doc_search_height',
            [
                'label'      => esc_html__( 'Height (px)', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 50
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .search-input-body input' => 'height: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_control(
            'doc_search_width',
            [
                'label'      => esc_html__( 'Width', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    '%' => [
                        'min'  => 5,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 80
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .search-input-body' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#f1f5f9',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .search-input-body input' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#4F46E5',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .search-input-body input' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'doc_search_padding',
            [
                'label'      => esc_html__( 'Padding (px)', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '5',
                    'right'    => '55',
                    'bottom'   => '5',
                    'left'     => '15',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .search-input-body input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'doc_search_color_border',
                'selector'       => '{{WRAPPER}} .search-inputs .search-input-body input',
                'size_units'     => ['px'],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid'
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '2',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '0',
                            'isLinked' => false
                        ]
                    ],
                    'color'  => [
                        'default' => '#D4D4D4'
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'doc_search_search_typography',
                'label'          => esc_html__( 'Typography', 'superdocs' ),
                'selector'       => '{{WRAPPER}} .search-inputs input',
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
            'section_preloader_style',
            [
                'label' => esc_html__( 'Preloader', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'doc_search_preloader_thickness',
            [
                'label'      => esc_html__( 'Thickness', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 5
                ]
            ]
        );

        $this->add_control(
            'doc_search_preloader_width',
            [
                'label'      => esc_html__( 'Width', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 30
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-search .loader' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_preloader_background_color',
            [
                'label'   => esc_html__( 'Background Color', 'superdocs' ),
                'type'    => Controls_Manager::COLOR,
                'alpha'   => false,
                'default' => '#AAB6C3'
            ]
        );

        $this->add_control(
            'doc_search_preloader_color',
            [
                'label'   => esc_html__( 'Color', 'superdocs' ),
                'type'    => Controls_Manager::COLOR,
                'alpha'   => false,
                'default' => '#4B42DD'
            ]
        );

        $this->add_responsive_control(
            'doc_search_preloader_margin',
            [
                'label'      => esc_html__( 'Margin', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '15',
                    'bottom'   => '0',
                    'left'     => '0',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-search .loader-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__( 'Button', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'doc_search_button_height',
            [
                'label'      => esc_html__( 'Height (px)', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 200,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 50
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .submit-button' => 'height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_button_width',
            [
                'label'      => esc_html__( 'Width', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    '%' => [
                        'min'  => 5,
                        'max'  => 50,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 20
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .submit-button' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'doc_search_button_padding',
            [
                'label'      => esc_html__( 'Padding (px)', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .submit-button button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );

        $this->add_control(
            'doc_search_button_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#DEDEE0',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .submit-button button' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_button_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .submit-button button' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'doc_search_button_border',
                'selector'       => '{{WRAPPER}} .search-inputs .submit-button button',
                'size_units'     => ['px'],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid'
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '2',
                            'right'    => '0',
                            'bottom'   => '2',
                            'left'     => '0',
                            'isLinked' => false
                        ]
                    ],
                    'color'  => [
                        'default' => '#D4D4D4'
                    ]
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'doc_search_button_typography',
                'label'          => esc_html__( 'Typography', 'superdocs' ),
                'selector'       => '{{WRAPPER}} .search-inputs button',
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
            'section_result_style',
            [
                'label' => esc_html__( 'Result', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'doc_search_gap_between_docs',
            [
                'label'      => esc_html__( 'Gap between docs (px)', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 100,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 10
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .superdocs-search-results ul' => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
        $this->add_control(
            'doc_search_box_max_height',
            [
                'label'      => esc_html__( 'Max height (px)', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => 'px',
                    'size' => 240
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .result-body' => 'max-height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_result_background_color',
            [
                'label'     => esc_html__( 'Background Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#f1f5f9',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .superdocs-search-results' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_result_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .superdocs-search-results li a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_result_doc_background_color',
            [
                'label'     => esc_html__( 'Background Color Doc Item', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#f1f5f9',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .superdocs-search-results li' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'doc_search_result_not_found_color',
            [
                'label'     => esc_html__( 'Not Found Text Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .search-inputs .superdocs-search-results .empty-result' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'doc_search_result_doc_padding',
            [
                'label'      => esc_html__( 'Padding Doc Item (px)', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '10',
                    'bottom'   => '10',
                    'left'     => '10',
                    'unit'     => 'px',
                    'isLinked' => true
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .superdocs-search-results ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'doc_search_result_padding',
            [
                'label'      => esc_html__( 'Padding (px)', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '10',
                    'right'    => '10',
                    'bottom'   => '10',
                    'left'     => '10',
                    'unit'     => 'px',
                    'isLinked' => true
                ],
                'selectors'  => [
                    '{{WRAPPER}} .search-inputs .superdocs-search-results' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );


        $this->add_responsive_control(
            'doc_search_result_margin',
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
                    '{{WRAPPER}} .search-inputs .result-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'doc_search_result_body_border',
                'selector'       => '{{WRAPPER}} .search-inputs .result-body',
                'size_units'     => ['px'],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid'
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '0',
                            'right'    => '2',
                            'bottom'   => '2',
                            'left'     => '2',
                            'isLinked' => false
                        ]
                    ],
                    'color'  => [
                        'default' => '#D4D4D4'
                    ]
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
		$settings = $this->get_settings_for_display();
		$preloaderThickness = $settings['doc_search_preloader_thickness']['size'].$settings['doc_search_preloader_thickness']['unit'];
		$products = get_posts([
			'post_type' => superdocs_post_type(),
			'meta_query' => [
				[
					'key'     => 'superdocs_product',
					'compare' => 'EXISTS'
				]
			]
		]);
		?>
        <style>
            .loader {
                border: <?php wp_commander_render($preloaderThickness) ?> solid <?php wp_commander_render($settings['doc_search_preloader_background_color'])?>;
                border-top: <?php wp_commander_render($preloaderThickness) ?> solid <?php wp_commander_render($settings['doc_search_preloader_color'])?>;
            }
        </style>
        <div class="superdocs">
			<div class="superdocs-search">
				<form action="" class="normal-search-form">
                    <input type="hidden" name="not_found_text" value="<?php wp_commander_render($settings['doc_search_not_found_text'])?>">
					<div class="search-inputs">
						<div class="product">
							<select name="product" id="product">
								<option value="0"><?php wp_commander_render($settings['doc_search_all_product']) ?></option>
								<?php foreach($products as $product):?>
									<option value="<?php wp_commander_render($product->ID);?>"><?php wp_commander_render($product->post_title);?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div class="search-input-body">
							<div class="search-input" style="width:100%;">
								<input style="width: 100%;" type="text" name="s" id="doc_search" autocomplete="off">
								<div class="loader-body">
									<div class="loader"></div>
								</div>
							</div>
							<div class="search-results">
                                <div class="result-body" style="display: none;overflow:scroll"></div>
                            </div>
						</div>
						<div class="submit-button">
							<button type="submit" style="width: 100%;height:100%;cursor:pointer;">
								<?php wp_commander_render($settings['doc_search_button_text'])?>
							</button>
						</div>
					</div>
				</form>
			</div>
        </div>
		<?php
    }
}

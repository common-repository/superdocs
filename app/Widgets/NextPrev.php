<?php

namespace SuperDocs\App\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;
use SuperDocs\App\Supports\GetNextPrevDoc;

class NextPrev extends Widget_Base
{
    public function get_name()
    {
        return 'superdocs-next-prev';
    }

    public function get_title()
    {
        return esc_html__( 'Next Prev', 'superdocs' );
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
        return ['superdocs', 'doc', 'content', 'knowledge base', 'next prev'];
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
            'superdocs_link_show_element',
            [
                'label'       => __( 'Show element', 'superdocs' ),
                'type'        => Controls_Manager::SELECT2,
                'multiple'    => true,
                'label_block' => true,
                'default'     => ['doc_title', 'direction_title', 'icon'],
                'options'     => [
                    'doc_title'       => esc_html__( 'Doc Title', 'superdocs' ),
                    'direction_title' => esc_html__( 'Direction Title', 'superdocs' ),
                    'icon'            => esc_html__( 'Icon', 'superdocs' )
                ]
            ]
        );

        $this->add_control(
            'superdocs_previous_icon',
            [
                'label'     => __( 'Previous Icon', 'superdocs' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-left',
                    'library' => 'fa-solid'
                ],
                'condition' => [
                    'superdocs_link_show_element' => 'icon'
                ]
            ]
        );

        $this->add_control(
            'superdocs_next_icon',
            [
                'label'     => __( 'Next Icon', 'superdocs' ),
                'type'      => Controls_Manager::ICONS,
                'default'   => [
                    'value'   => 'fas fa-arrow-right',
                    'library' => 'fa-solid'
                ],
                'condition' => [
                    'superdocs_link_show_element' => 'icon'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_order',
            [
                'label' => esc_html__( 'Order', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

        $previous_repeater = new Repeater();

        $this->add_control(
            'superdocs_previous_link_order',
            [
                'label'        => esc_html__( 'Previous', 'superdocs' ),
                'type'         => Controls_Manager::REPEATER,
                'fields'       => $previous_repeater->get_controls(),
                'default'      => [
                    [
                        'list_key'   => 'icon',
                        'list_title' => esc_html__( 'Icon', 'superdocs' )
                    ],
                    [
                        'list_key'   => 'title',
                        'list_title' => esc_html__( 'Title', 'superdocs' )
                    ]
                ],
                'title_field'  => '{{{ list_title }}}',
                'item_actions' => [
                    'add'       => false,
                    'duplicate' => false,
                    'remove'    => false,
                    'sort'      => true
                ]
            ]
        );

        $next_repeater = new Repeater();

        $this->add_control(
            'superdocs_next_link_order',
            [
                'label'        => esc_html__( 'Next', 'superdocs' ),
                'type'         => Controls_Manager::REPEATER,
                'fields'       => $next_repeater->get_controls(),
                'default'      => [
                    [
                        'list_key'   => 'title',
                        'list_title' => esc_html__( 'Title', 'superdocs' )
                    ],
                    [
                        'list_key'   => 'icon',
                        'list_title' => esc_html__( 'Icon', 'superdocs' )
                    ]
                ],
                'title_field'  => '{{{ list_title }}}',
                'item_actions' => [
                    'add'       => false,
                    'duplicate' => false,
                    'remove'    => false,
                    'sort'      => true
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_style',
            [
                'label' => esc_html__( 'Style', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'superdocs_link_row',
            [
                'label'     => __( 'Row Item', 'superdocs' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '2',
                'options'   => [
                    '1' => esc_html__( 'Single', 'superdocs' ),
                    '2' => esc_html__( 'Both', 'superdocs' )
                ],
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));'
                ]
            ]
        );

        $this->add_responsive_control(
            'superdocs_link_gap',
            [
                'label'      => esc_html__( 'Gap between', 'superdocs' ),
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
                    'size' => 20
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev' => 'gap: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'superdocs_background_color',
            [
                'label'     => esc_html__( 'Background Color ', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#F4F4F6',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev a' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'superdocs_background_hover_color',
            [
                'label'     => esc_html__( 'Background Color Hover', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#F2F3FF',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev a:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'superdocs_link_padding',
            [
                'label'      => esc_html__( 'Padding', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '5',
                    'right'    => '12',
                    'bottom'   => '5',
                    'left'     => '12',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'           => 'superdocs_link_border',
                'selector'       => '{{WRAPPER}} .superdocs-next-prev a',
                'size_units'     => ['px'],
                'fields_options' => [
                    'border' => [
                        'default' => 'solid'
                    ],
                    'width'  => [
                        'default' => [
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => true
                        ]
                    ],
                    'color'  => [
                        'default' => '#C6BDBD'
                    ]
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_doc_title',
            [
                'label'     => esc_html__( 'Doc Title', 'superdocs' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'superdocs_link_show_element' => 'doc_title'
                ]
            ]
        );

        $this->add_control(
            'superdocs_doc_title_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#19181A',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev .doc_title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'superdocs_doc_title_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#5E0DFF',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev a:hover .doc_title' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->start_controls_tabs(
            'superdocs_link_title_tabs'
        );

        $this->start_controls_tab(
            'superdocs_link_title_previous_tab',
            [
                'label' => esc_html__( 'Previous', 'superdocs' )
            ]
        );

        $this->add_responsive_control(
            'superdocs_prev_link_title_width',
            [
                'label'      => esc_html__( 'Width', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 90
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .prev .title' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'superdocs_link_doc_prev_title_alignment',
            [
                'label'     => esc_html__( 'Alignment', 'superdocs' ),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'superdocs' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'superdocs' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'superdocs' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'default'   => 'right',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev .prev .title' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'superdocs_link_doc_prev_title_padding',
            [
                'label'      => esc_html__( 'Padding', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .prev .doc_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'after'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'superdocs_link_title_next_tab',
            [
                'label' => esc_html__( 'Next', 'superdocs' )
            ]
        );

        $this->add_responsive_control(
            'superdocs_next_link_title_width',
            [
                'label'      => esc_html__( 'Width', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 90
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .next .title' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'superdocs_link_doc_next_title_alignment',
            [
                'label'     => esc_html__( 'Alignment', 'superdocs' ),
                'type'      => Controls_Manager::CHOOSE,
                'default'   => 'left',
                'options'   => [
                    'left'   => [
                        'title' => esc_html__( 'Left', 'superdocs' ),
                        'icon'  => 'eicon-text-align-left'
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'superdocs' ),
                        'icon'  => 'eicon-text-align-center'
                    ],
                    'right'  => [
                        'title' => esc_html__( 'Right', 'superdocs' ),
                        'icon'  => 'eicon-text-align-right'
                    ]
                ],
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev .next .title' => 'text-align: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'superdocs_link_doc_next_title_padding',
            [
                'label'      => esc_html__( 'Padding', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .next .doc_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'after'
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'doc_title_typography',
                'label'          => esc_html__( 'Typography', 'superdocs' ),
                'selector'       => '{{WRAPPER}} .superdocs-next-prev .doc_title',
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
                        'default' => 'capitalize'
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
            'section_direction',
            [
                'label'     => esc_html__( 'Direction Text', 'superdocs' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'superdocs_link_show_element' => 'direction_title'
                ]
            ]
        );

        $this->add_control(
            'superdocs_direction_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#515151',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev .direction' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'superdocs_direction_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#5E0DFF',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev a:hover .direction' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'superdocs_link_direction_padding',
            [
                'label'      => esc_html__( 'Padding', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .direction' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
                'separator'  => 'before'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'           => 'direction_text_typography',
                'label'          => esc_html__( 'Typography', 'superdocs' ),
                'selector'       => '{{WRAPPER}} .superdocs-next-prev .direction',
                'exclude'        => ['font_style', 'letter_spacing'],
                'fields_options' => [
                    'typography'     => [
                        'default' => 'custom'
                    ],
                    'font_size'      => [
                        'label'      => esc_html__( 'Font Size (px)', 'superdocs' ),
                        'default'    => [
                            'size' => '9',
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
            'section_icon',
            [
                'label'     => esc_html__( 'Icon', 'superdocs' ),
                'tab'       => Controls_Manager::TAB_STYLE,
                'condition' => [
                    'superdocs_link_show_element' => 'icon'
                ]
            ]
        );

        $this->add_responsive_control(
            'superdocs_next_link_icon_size',
            [
                'label'      => esc_html__( 'Size', 'superdocs' ),
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
                    'size' => 14
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .icon i' => 'font-size: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'superdocs_icon_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#040405',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev .icon' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'superdocs_icon_hover_color',
            [
                'label'     => esc_html__( 'Hover Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#5E0DFF',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-next-prev a:hover .icon' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->start_controls_tabs(
            'superdocs_link_icon_tabs'
        );

        $this->start_controls_tab(
            'superdocs_link_icon_previous_tab',
            [
                'label' => esc_html__( 'Previous', 'superdocs' )
            ]
        );

        $this->add_responsive_control(
            'superdocs_prev_link_icon_width',
            [
                'label'      => esc_html__( 'Width', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 10
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .prev .icon' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'superdocs_link_prev_icon_padding',
            [
                'label'      => esc_html__( 'Padding', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '3',
                    'right'    => '3',
                    'bottom'   => '3',
                    'left'     => '3',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .prev .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'superdocs_link_icon_next_tab',
            [
                'label' => esc_html__( 'Next', 'superdocs' )
            ]
        );

        $this->add_responsive_control(
            'superdocs_next_link_icon_width',
            [
                'label'      => esc_html__( 'Width', 'superdocs' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range'      => [
                    'px' => [
                        'min'  => 0,
                        'max'  => 1000,
                        'step' => 1
                    ]
                ],
                'default'    => [
                    'unit' => '%',
                    'size' => 10
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .next .icon' => 'width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'superdocs_link_next_icon_padding',
            [
                'label'      => esc_html__( 'Padding', 'superdocs' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'default'    => [
                    'top'      => '3',
                    'right'    => '3',
                    'bottom'   => '3',
                    'left'     => '15',
                    'unit'     => 'px',
                    'isLinked' => false
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-next-prev .next .icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings       = $this->get_settings_for_display();
		$elementor      = \Elementor\Plugin::$instance;

        $orderCss = '<style>';

        foreach($settings['superdocs_previous_link_order'] as $key => $item) {
           $orderCss .='.superdocs-next-prev .prev .'.$item['list_key'] . '{order:' . ($key + 1) . ';}';
        }
        foreach($settings['superdocs_next_link_order'] as $key => $item) {
           $orderCss .='.superdocs-next-prev .next .'.$item['list_key'] . '{order:' . ($key + 1) . ';}';
        }

        $orderCss .= '</style>';
        wp_commander_render($orderCss);
        ?>
        <div class="superdocs">
            <div class="superdocs-next-prev">
            <?php
            
            if ( $elementor->editor->is_edit_mode() || is_preview()) {?>
                    <a class="link prev" href="">
                        <?php if( array_intersect($settings['superdocs_link_show_element'], ['direction_title', 'doc_title']) ): ?>
                            <div class="title">
                                <?php if(in_array('direction_title', $settings['superdocs_link_show_element'])): ?>
                                    <div class="direction">Previous</div>
                                <?php endif; ?>
                                <?php if(in_array('doc_title', $settings['superdocs_link_show_element'])): ?>
                                    <div class="doc_title">Doc title</div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(in_array('icon', $settings['superdocs_link_show_element'])): ?>
                            <div class="icon">
                                <?php Icons_Manager::render_icon($settings['superdocs_previous_icon'])?>
                            </div>
                        <?php endif; ?>
                    </a>
                    <a class="link next" href="">
                        <?php if( array_intersect($settings['superdocs_link_show_element'], ['direction_title', 'doc_title']) ): ?>
                            <div class="title">
                                <?php if(in_array('direction_title', $settings['superdocs_link_show_element'])): ?>
                                    <div class="direction">Next</div>
                                <?php endif; ?>
                                <?php if(in_array('doc_title', $settings['superdocs_link_show_element'])): ?>
                                    <div class="doc_title">Doc title</div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(in_array('icon', $settings['superdocs_link_show_element'])): ?>
                            <div class="icon">
                                <?php Icons_Manager::render_icon($settings['superdocs_next_icon'])?>
                            </div>
                        <?php endif; ?>
                    </a>
            <?php } else { 
                
                global $post;

                if(empty($post->ID)) {
                    return;
                }
                $docId          = $post->ID;
                $productId      = get_post_meta( $docId, 'productId', true );
                $categoryId     = get_post_meta( $docId, 'categoryId', true );
                $getNextPrevDoc = new GetNextPrevDoc;
                $links          = $getNextPrevDoc->get( $docId, $productId, $categoryId );
                
                if(is_object($links['prev'])): ?>
                    <a class="link prev" href="<?php wp_commander_render(get_the_permalink($links['prev']))?>">
                        <?php if( array_intersect($settings['superdocs_link_show_element'], ['direction_title', 'doc_title']) ): ?>
                            <div class="title">
                                <?php if(in_array('direction_title', $settings['superdocs_link_show_element'])): ?>
                                    <div class="direction">Previous</div>
                                <?php endif; ?>
                                <?php if(in_array('doc_title', $settings['superdocs_link_show_element'])): ?>
                                    <div class="doc_title">
                                        <?php wp_commander_render($links['prev']->post_title) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(in_array('icon', $settings['superdocs_link_show_element'])): ?>
                            <div class="icon">
                                <?php Icons_Manager::render_icon($settings['superdocs_previous_icon'])?>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
                <?php if(is_object($links['next'])): ?>
                    <a class="link next" href="<?php wp_commander_render(get_the_permalink($links['next']))?>">
                        <?php if( array_intersect($settings['superdocs_link_show_element'], ['direction_title', 'doc_title']) ): ?>
                            <div class="title">
                                <?php if(in_array('direction_title', $settings['superdocs_link_show_element'])): ?>
                                    <div class="direction">Next</div>
                                <?php endif; ?>
                                <?php if(in_array('doc_title', $settings['superdocs_link_show_element'])): ?>
                                    <div class="doc_title">
                                        <?php wp_commander_render($links['next']->post_title) ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if(in_array('icon', $settings['superdocs_link_show_element'])): ?>
                            <div class="icon">
                                <?php Icons_Manager::render_icon($settings['superdocs_next_icon'])?>
                            </div>
                        <?php endif; ?>
                    </a>
                <?php endif;
                }?>
            </div>
        </div>
    <?php
    }
}

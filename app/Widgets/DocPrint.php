<?php

namespace SuperDocs\App\Widgets;

use Elementor\Controls_Manager;
use Elementor\Icons_Manager;
use Elementor\Widget_Base;

class DocPrint extends Widget_Base
{
    public function get_name()
    {
        return 'superdocs-print';
    }

    public function get_title()
    {
        return esc_html__( 'Print', 'superdocs' );
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
        return ['superdocs', 'doc', 'content', 'knowledge base', 'print'];
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
            'doc_print_content_area',
            [
                'label'              => esc_html__( 'Print', 'superdocs' ),
                'type'               => Controls_Manager::SELECT,
                'default'            => 'only_content_area',
                'options'            => [
                    'only_content_area' => esc_html__( 'Only Content Area', 'superdocs' ),
                    'full_window'       => esc_html__( 'Full Window', 'superdocs' )
                ],
                'frontend_available' => true
            ]
        );

        $this->add_control(
            'doc_print_icon',
            [
                'label'   => __( 'Icon', 'superdocs' ),
                'type'    => Controls_Manager::ICONS,
                'default' => [
                    'value'   => 'fas fa-print',
                    'library' => 'fa-solid'
                ]
            ]
        );

        $this->add_control(
            'doc_print_icon_alignment',
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
                'default'   => 'center',
                'toggle'    => true,
                'selectors' => [
                    '{{WRAPPER}} .superdocs-print' => 'text-align: {{VALUE}};'
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

        $this->add_control(
            'doc_print_icon_size',
            [
                'label'      => esc_html__( 'Icon Size', 'superdocs' ),
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
                    'size' => 25
                ],
                'selectors'  => [
                    '{{WRAPPER}} .superdocs-print'     => 'font-size: {{SIZE}}{{UNIT}} !important;',
                    '{{WRAPPER}} .superdocs-print svg' => 'width: {{SIZE}}{{UNIT}} !important;'
                ]
            ]
        );

        $this->add_control(
            'doc_print_icon_color',
            [
                'label'     => esc_html__( 'Color', 'superdocs' ),
                'type'      => Controls_Manager::COLOR,
                'alpha'     => false,
                'default'   => '#4f46e5',
                'selectors' => [
                    '{{WRAPPER}} .superdocs-print i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .superdocs-print svg' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
		$settings = $this->get_settings_for_display();
		?>
        <div class="superdocs">
            <div class="superdocs-print" style="cursor: pointer;">
                <?php Icons_Manager::render_icon($settings['doc_print_icon'])?>
            </div>
        </div>
		<?php
    }
}

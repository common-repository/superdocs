<?php

namespace SuperDocs\App\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;

class Breadcrumb extends Widget_Base
{
    public function get_name()
    {
        return 'superdocs-breadcrumb';
    }

    public function get_title()
    {
        return esc_html__( 'Breadcrumb', 'superdocs' );
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
        return ['superdocs', 'doc', 'content', 'knowledge base', 'breadcrumb'];
    }

	protected function register_controls()
	{
		$this->start_controls_section(
            'section_home',
            [
                'label' => esc_html__( 'Home', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

		$this->add_control(
			'superdocs_home_text',
			[
				'label'     => esc_html__( 'Text', 'superdocs' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Home',
			]
		);

		$this->add_control(
			'superdocs_home_url',
			[
				'label'     => esc_html__( 'Url', 'superdocs' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'home',
				'options'    => [
					'home' => esc_html__('Home', 'superdocs'),
					'custom' => esc_html__('Custom', 'superdocs')
				]
			]
		);

		$this->add_control(
			'superdocs_home_custom_url',
			[
				'label'       => esc_html__( 'Custom Url', 'superdocs' ),
				'type'        => Controls_Manager::URL,
				'options'     => false,
				'condition'   => [
					'superdocs_home_url' => 'custom'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
            'section_docs',
            [
                'label' => esc_html__( 'Documentations', 'superdocs' ),
                'tab'   => Controls_Manager::TAB_CONTENT
            ]
        );

		$this->add_control(
			'superdocs_docs_text',
			[
				'label'     => esc_html__( 'Text', 'superdocs' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Documentations',
			]
		);

		$this->add_control(
			'superdocs_docs_url',
			[
				'label'     => esc_html__( 'Url', 'superdocs' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'docs',
				'options'    => [
					'docs' => '/docs',
					'custom' => esc_html__('Custom', 'superdocs')
				]
			]
		);

		$this->add_control(
			'superdocs_docs_custom_url',
			[
				'label'       => esc_html__( 'Custom Url', 'superdocs' ),
				'type'        => Controls_Manager::URL,
				'options'     => false,
				'condition'   => [
					'superdocs_docs_url' => 'custom'
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
			'superdocs_color',
			[
				'label'     => esc_html__( 'Color', 'superdocs' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .superdocs .breadcrumbs .breadcrumb-item a' => 'color: {{VALUE}};'
				]
			]
		);

		$this->add_control(
			'superdocs_active_color',
			[
				'label'     => esc_html__( 'Active Color', 'superdocs' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#4F46E5',
				'selectors' => [
					'{{WRAPPER}} .superdocs .breadcrumbs .breadcrumb-active' => 'color: {{VALUE}} !important;'
				]
			]
		);

		$this->add_control(
			'superdocs_arrow_color',
			[
				'label'     => esc_html__( 'Arrow Color', 'superdocs' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'default'   => '#6298BC',
				'selectors' => [
					'{{WRAPPER}} .superdocs .breadcrumbs .breadcrumb-icon' => 'color: {{VALUE}} !important;'
				]
			]
		);

		$this->add_control(
			'superdocs_gap',
			[
				'label'      => esc_html__( 'Gap between', 'superdocs' ),
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
				],
				'selectors'  => [
					'{{WRAPPER}} .superdocs .breadcrumbs' => 'gap: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_control(
			'superdocs_arrow_width',
			[
				'label'      => esc_html__( 'Width', 'superdocs' ),
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
					'size' => 8
				],
				'selectors'  => [
					'{{WRAPPER}} .superdocs .breadcrumbs .breadcrumb-icon' => 'width: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'           => 'superdocs_typography',
				'label'          => esc_html__( 'Typography', 'superdocs' ),
				'selectors'      => [
					'{{WRAPPER}} .superdocs .breadcrumbs .breadcrumb-item',
				],
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
	}

    protected function render()
    {
		global $post;
		if(empty($post->ID)) {
			return;
		}
		$settings     = $this->get_settings_for_display();
		$docTitle     = $post->post_title;
		$productId    = get_post_meta($post->ID, 'productId', true);
		$product      = get_post($productId);
		$productTitle = '';
		$productLink  = '';

		if($product) {
			$productTitle = $product->post_title;
			$productLink  = get_post_permalink($product);
		}

		if( 'home' === $settings['superdocs_home_url'] ) {
			$homeUrl = get_site_url();
		} else {
			$homeUrl = $settings['superdocs_home_custom_url']['url'];
		}

		if( 'docs' === $settings['superdocs_docs_url'] ) {
			$docsUrl = get_site_url(null, 'docs');
		} else {
			$docsUrl = $settings['superdocs_docs_custom_url']['url'];
		}

		?>
		<nav class="superdocs">
			<ul class="breadcrumbs">
				<li class="breadcrumb-item">
					<a href="<?php wp_commander_render( $homeUrl )?>">
						<?php wp_commander_render($settings['superdocs_home_text'])?>
					</a>
				</li>
				<li class="breadcrumb-item">
					<?php $this->arrowIcon()?>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php wp_commander_render( $docsUrl )?>">
						<?php wp_commander_render($settings['superdocs_docs_text'])?>
					</a>
				</li>
				<li class="breadcrumb-item">
					<?php $this->arrowIcon()?>
				</li>
				<li class="breadcrumb-item">
					<a href="<?php wp_commander_render($productLink)?>">
						<?php wp_commander_render($productTitle)?>
					</a>
				</li>
				<li class="breadcrumb-item">
					<?php $this->arrowIcon()?>
				</li>
				<li class="breadcrumb-item breadcrumb-active">
					<?php wp_commander_render($docTitle)?>
				</li>
			</ul>
		</nav>
	<?php
    }

	public function arrowIcon() {
		?>
		<span class="breadcrumb-icon">
			<svg class="breadcrumb-delimiter-icon svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
				<path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z">
				</path>
			</svg>
		</span>
		<?php
	}
}

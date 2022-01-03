<?php
namespace DROIT_ELEMENTOR\Widgets;

if (!defined('ABSPATH')) {exit;}

class Droit_Addons_Img_Carousel extends \Elementor\Widget_Base{

    // Get Control ID
    protected function get_control_id($control_id)
    {
        return $control_id;
    }
    public function get_pro_testimonials_settings($control_key)
    {
        $control_id = $this->get_control_id($control_key);
        return $this->get_settings($control_id);
    }

    public function get_name()
    {
        return 'droit-img-carousel';
    }

    public function get_title()
    {
        return esc_html__( 'Img Carousel', 'droit-addons' );
    }

    public function get_icon()
    {
        return ' eicon-img-carousel addons-icon';
    }

    public function get_categories()
    {
        return ['droit_addons'];
    }

    public function get_keywords()
    {
        return [ 'Image Carousel',
            'image carousel',
            'Image Slider',
            'Droit Image Slider',
            'dl Image Slider',
            'droit image carousel',
            'droit-image carousel',
            'dl image carousel',
            'dl-image carousel',
            'Images',
            'images',
            'Carousel',
            'carousel',
            'Slider',
            'Sliders',
            'slider',
            'sliders',
            'droit',
            'dl',
            'addons',
            'addon'
        ];
    }

    protected function _register_controls()
    {
        do_action('dl_widgets/test/register_control/start', $this);

        // add content 
        $this->_content_control();
        
        //style section
        $this->_styles_control();
        
        do_action('dl_widgets/test/register_control/end', $this);

        // by default
        do_action('dl_widget/section/style/custom_css', $this);
        
    }

    public function _content_control(){
        //start subscribe layout
        $this->start_controls_section(
            '_dl_testimonial_Content_section',
            [
                'label' => __('Content', 'droit-addons'),
            ]
        );

        $this->_dl_pro_carousel_content_repeater_controls();

        $this->end_controls_section();
        //start subscribe layout end

        $this->_dl_pro_testimonials_slider_option_controls();

    }

    // Testimonial Repeater
    protected function _dl_pro_carousel_content_repeater_controls()
    {
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            '_dl_pro_testimonial_name', [
                'label'       => __('Title', 'droit-addons'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'placeholder' => __('Enter Title', 'droit-addons'),
                'default'     => __('Enter Title', 'droit-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            '_dl_pro_testimonial_text', [
                'label'       => __('Description', 'droit-addons'),
                'type'        => \Elementor\Controls_Manager::TEXTAREA,
                'placeholder' => __('Enter Content', 'droit-addons'),
                'default'     => __('Enter Content', 'droit-addons'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            '_dl_pro_testimonial_image', [
                'label'      => __('Client Image', 'droit-addons'),
                'type'       => \Elementor\Controls_Manager::MEDIA,
                'default'    => [
                    'url'    => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'show_label' => false,
            ]
        );
        do_action('dl_pro_testimonial', $repeater);
        $this->add_control(
            '_dl_pro_testimonial_list',
            [
                'label' => __('Testimonial', 'droit-addons'),
                'show_label' => false,
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        '_dl_pro_testimonial_name' => __('Droitthemes', 'droit-addons'),
                        '_dl_pro_testimonial_text' => __(' “Droitadons presents your services with flexible, convenient and multipurpose layouts.“', 'droit-addons'),
                        '_dl_pro_testimonial_image' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    [
                        '_dl_pro_testimonial_name' => __('Droitthemes', 'droit-addons'),
                        '_dl_pro_testimonial_text' => __(' “Droitadons presents your services with flexible, convenient and multipurpose layouts.“', 'droit-addons'),
                        '_dl_pro_testimonial_image' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    [
                        '_dl_pro_testimonial_name' => __('Droitthemes', 'droit-addons'),
                        '_dl_pro_testimonial_text' => __(' “Droitadons presents your services with flexible, convenient and multipurpose layouts.“', 'droit-addons'),
                        '_dl_pro_testimonial_image' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
                    [
                        '_dl_pro_testimonial_name' => __('Droitthemes', 'droit-addons'),
                        '_dl_pro_testimonial_text' => __(' “Droitadons presents your services with flexible, convenient and multipurpose layouts.“', 'droit-addons'),
                        '_dl_pro_testimonial_image' => \Elementor\Utils::get_placeholder_image_src(),
                    ],

                ],
                'title_field' => '{{{ _dl_pro_testimonial_name }}}',
            ]
        );
    }

    // Slider Option
    public function _dl_pro_testimonials_slider_option_controls()
    {
        $this->start_controls_section(
            '_dl_pro_testimonial_options_section',
            [
                'label' => esc_html__('Settings', 'droit-addons'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        $this->add_control(
            'dl_testimonial_perpage',
            [
                'label' => __( 'Perpage', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 2,
            ]
        );
        $this->add_control(
            'dl_testimonial_speed',
            [
                'label' => __( 'Speed', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::HIDDEN,
                'min' => 1,
                'max' => 1000000,
                'step' => 100,
                'default' => 1000,
            ]
        );
        
        $this->add_control(
            'dl_testimonial_autoplay',
            [
                'label' => __('Autoplay', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'true',
                'return_value' => 'true',
            ]
        );

        $this->add_control(
            'dl_testimonial_auto_delay',
            [
                'label' => __( 'Delay [autoplay]', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000000,
                'step' => 1,
                'default' => 500,
                'condition' => [ 'dl_testimonial_autoplay' => 'true']
            ]
        );
        $this->add_control(
            'dl_testimonial_direction',
            [
                'label' => __('Enable Vertical', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'return_value' => 'yes',
            ]
        );
        $this->add_control(
            'dl_testimonial_loop',
            [
                'label' => __('Enable Loop', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );
        
        $this->add_control(
            'dl_testimonial_centered',
            [
                'label' => __('Centered', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'dl_testimonial_pagination',
            [
                'label' => __('Enable Pagination', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'no',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'dl_testimonial_pagination_type',
            [
                'label' => __( 'Pagi Type', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'bullets' => 'Bullets',
                    'fraction' => 'Fraction',
                    'progressbar' => 'Progressbar',
                ],
                'default' => 'bullets',
                'condition' => [ 'dl_testimonial_pagination' => 'yes']
            ]
        );

        $this->add_control(
            'dl_testimonial_space',
            [
                'label' => __( 'Space Between', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 1000000,
                'step' => 1,
                'default' => 30,
            ]
        );
        $this->add_control(
            'dl_testimonial_effect',
            [
                'label' => __( 'Effect', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'slide' => 'Slide',
                    'fade' => 'Fade',
                    'cube' => 'Cube',
                    'coverflow' => 'Coverflow',
                    'flip' => 'Flip',
                ],
                'default' => 'slide',
            ]
        );

        $this->add_control(
            'dl_testimonial_enable_slide_control',
            [
                'label' => __('Enable Slide Control', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'default' => 'yes',
                'return_value' => 'yes',
            ]
        );

        $this->add_control(
            'dl_testimonial_nav_left_icon',
            [
                'label' => __( 'Left Icon', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-left',
                    'library' => 'solid',
                ],
                'condition' => [ 'dl_testimonial_enable_slide_control' => 'yes']
            ]
        );

        $this->add_control(
            'dl_testimonial_nav_right_icon',
            [
                'label' => __( 'Right Icon', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'solid',
                ],
                'condition' => [ 'dl_testimonial_enable_slide_control' => 'yes']
            ]
        );
        
        $this->add_control(
            'dl_breakpoints_enable',
            [
                'label' => esc_html__('Responsive', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'droit-addons'),
                'label_off' => esc_html__('No', 'droit-addons'),
                'return_value' => 'yes',
                'default' => 'label_off',
                'separator' => 'before'
            ]
        );
        
        $repeater = new \Elementor\Repeater();
        $repeater->add_control(
            'dl_breakpoints_width',
            [
                'label' => __('Max Width', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 3000,
                'step' => 1,
                'default' => '',
            ]
        );
        $repeater->add_control(
            'dl_breakpoints_perpage',
            [
                'label' => __('Slides Per View', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 10,
                'step' => 1,
                'default' => 1,
            ]
        );
        $repeater->add_control(
            'dl_breakpoints_space',
            [
                'label' => __('Space Between', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 1000,
                'step' => 1,
                'default' => 30,
            ]
        );
        $repeater->add_control(
            'dl_breakpoints_center',
            [
                'label' => esc_html__('Center', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'droit-addons'),
                'label_off' => esc_html__('No', 'droit-addons'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        do_action('dl_widgets/adslider/settings/repeater', $repeater);
        
        $this->add_control(
            'dl_breakpoints',
            [
                'label' => __('Content', 'droit-addons'),
                'show_label' => false,
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'dl_breakpoints_width' => 1440,
                        'dl_breakpoints_perpage' => 1,
                        'dl_breakpoints_space' => 30,
                    ],
                    [
                        'dl_breakpoints_width' => 1024,
                        'dl_breakpoints_perpage' => 1,
                        'dl_breakpoints_space' => 30,
                    ],
                    [
                        'dl_breakpoints_width' => 768,
                        'dl_breakpoints_perpage' => 1,
                        'dl_breakpoints_space' => 30,
                    ],
                    [
                        'dl_breakpoints_width' => 576,
                        'dl_breakpoints_perpage' => 1,
                        'dl_breakpoints_space' => 30,
                    ],

                ],
                'title_field' => 'Max Width: {{{ dl_breakpoints_width }}}',
                'condition' => [
                    'dl_breakpoints_enable' => ['yes'],
                ],
            ]
        );


        $this->add_control(
            'dl_testimonial_mouseover',
            [
                'label' => __( 'MouseOver Settings', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'dl_testimonial_mouseover_enable',
            [
                'label' => esc_html__('Enable', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'droit-addons'),
                'label_off' => esc_html__('No', 'droit-addons'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );
        $this->end_controls_section();
    }

    public function _styles_control(){
        $this->_dl_pro_testimonial_general_style_controls();
        $this->_dl_pro_testimonial_content_style_controls();
        $this->_dl_pro_testimonial_client_info();
        $this->_dl_pro_testimonials_slider_navigation_controls();
    }
    public function _dl_pro_testimonial_general_style_controls()
    {
        $this->start_controls_section(
            '_dl_pro_testimonials_general_style_section',
            [
                'label' => _x('General', 'droit-addons'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

                $this->add_responsive_control(
            '_dl_pro_testimonials_align',
            [
                'label' => __('Alignment', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'droit-addons'),
                        'icon' => 'fa fa-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'droit-addons'),
                        'icon' => 'fa fa-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'droit-addons'),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => '',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_carousel_slider_wrapper' => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => '_dl_pro_testimonials_bg',
                'label' => __('Background', 'droit-addons'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .dl_pro_carousel_slider_wrapper',
                'fields_options' => [
                    'background' => [
                        'label' => __('Background Color', 'droit-addons'),
                        'default' => 'classic',
                    ],
                    'color' => [
                        'default' => '',
                    ],
                ],
            ]
        );
        
        $this->add_responsive_control(
            '_dl_pro_testimonials_box_padding',
            [
                'label' => __('Padding', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'devices' => [ 'desktop', 'tablet', 'mobile' ],
                'desktop_default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'isLinked' => true,
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'top' => '40',
                    'right' => '40',
                    'bottom' => '40',
                    'left' => '40',
                    'isLinked' => true,
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'top' => '',
                    'right' => '',
                    'bottom' => '',
                    'left' => '',
                    'isLinked' => true,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_carousel_slider_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => '_dl_pro_testimonials_border',
                'label' => __('Box Border', 'droit-addons'),
                'selector' => '{{WRAPPER}} .dl_pro_carousel_slider_wrapper',
            ]
        );
        $this->add_responsive_control(
            '_dl_pro_testimonials_box_border_radius',
            [
                'label' => __('Border Radius', 'droit-addons'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .dl_pro_carousel_slider_wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => '_dl_pro_testimonials_box_shadow',
                'label' => __('Box Shadow', 'droit-addons'),
                'selector' => '{{WRAPPER}} .dl_pro_carousel_slider_wrapper',
            ]
        );


        do_action('dl_pro_testimonial_general', $this);
        $this->end_controls_section();
    }
    public function _dl_pro_testimonial_content_style_controls()
    {

        $this->start_controls_section(
            '_dl_pro_testimonial__content_style_section',
            [
                'label' => _x('Content', 'droit-addons'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
			'_dl_pro_testimonial_mane_separator',
			[
				'label' => __( 'Title', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);
        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => '_dl_pro_testimonial_mane_typography',
				'label' => __( 'Typography', 'droit-addons' ),
				'selector' => '{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_name',
			]
		);
        $this->add_control(
			'_dl_pro_testimonial_name_color',
			[
				'label' => __( 'Color', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_name' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_control(
			'dl_pro_testimonial_slider_name_spacing',
			[
				'label' => __( 'Spacing', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 7,
				],
				'selectors' => [
                    '{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_name' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
			]
		);

        $this->add_control(
			'_dl_pro_testimonial_content_separator',
			[
				'label' => __( 'Content', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => '_dl_pro_testimonial_content_typography',
				'label' => __( 'Typography', 'droit-addons' ),
                'selector' => '{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_text',
			]
		);

        $this->add_control(
			'_dl_pro_testimonial_content_color',
			[
				'label' => __( 'Color', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_text' => 'color: {{VALUE}}',
				],
			]
		);
        $this->add_control(
			'dl_pro_carousel_slider_wrapper_spacing',
			[
				'label' => __( 'Spacing', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
                    '{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_text' => 'margin-bottom: {{SIZE}}{{UNIT}}',
                ],
			]
		);

        

        
        do_action('dl_pro_testimonial_content', $this);
        $this->end_controls_section();
    }

    public function _dl_pro_testimonial_client_info()
    {

        $this->start_controls_section(
            '_dl_pro_testimonial_client_info_section',
            [
                'label' => _x('Client Info', 'droit-addons'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
			'testimonial_client_spacing',
			[
				'label' => __( 'Spacing', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_carousel_info_inner ' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
        $this->add_control(
			'_dl_pro_testimonial_image_separator',
			[
				'label' => __( 'Images', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::HIDDEN,
				'separator' => 'before',
			]
		);
        $this->add_control(
			'_dl_pro_testimonial_image_size_width',
			[
				'label' => __( 'Image Width', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_carousel_info_inner .dl-testimonial-reviewer img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'_dl_pro_testimonial_image_size_height',
			[
				'label' => __( 'Image Height', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
					],
                    '%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_carousel_info_inner .dl-testimonial-reviewer img' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);


        $this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => '_dl_pro_testimonial_image_border',
				'selector' => '{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_carousel_info_inner .dl-testimonial-reviewer img',
			]
		);
		$this->add_control(
			'_dl_pro_testimonial_image_border_radius',
			[
				'label' => __( 'Border Radius', 'droit-addons' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .dl_pro_carousel_slider_wrapper .dl_carousel_info_inner .dl-testimonial-reviewer img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        do_action('dl_pro_testimonial_client_info', $this);
        $this->end_controls_section();
    }


    public function _dl_pro_testimonials_slider_navigation_controls()
    {
        $this->start_controls_section(
            'testimonial_btn_navigation_style_content',
            [
                'label' => __( 'Navigation', 'droit-addons' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [ 'dl_testimonial_enable_slide_control' => 'yes']
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_nav_button_icon_alignment',
            [
                'label' => __( 'Position', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'relative' => __( 'Normal', 'droit-addons' ),
                    'absolute' => __( 'Fixed', 'droit-addons' ),
                ],
                'default' => 'relative',
                'selectors' => [
                    '{{wrapper}} .swiper_testimonial_nav_button' => 'position: {{VALUE}}'
                ],
                
            ]
        );

        $this->add_control(
            'swiper_testimonial_next_nav_button_inner',
            [
                'label' => __( 'Next', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                ],
            ]
        );
        $this->add_control(
            'swiper_testimonial_next_nav_button_align',
            [
                'label' => __( 'Alignment', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'droit-addons' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'droit-addons' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_nav_button_top_spacing',
            [
                'label' => __( 'Top', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .dl-slider-next ' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                ],
            ]
        );

        $this->add_responsive_control(
            'swiper_testimonial_nav_button_left_spacing',
            [
                'label' => __( 'Left', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .dl-slider-next ' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_next_nav_button_align' => ['left'],
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_nav_button_right_spacing',
            [
                'label' => __( 'Right', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .dl-slider-next ' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                    'swiper_testimonial_next_nav_button_align' => ['right'],
                ],
            ]
        );
        
        $this->add_control(
            'swiper_testimonial_prev_nav_button_section',
            [
                'label' => __( 'Previous', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                ],
            ]
        );
        $this->add_control(
            'swiper_testimonial_prev_nav_button_align',
            [
                'label' => __( 'Alignment', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __( 'Left', 'droit-addons' ),
                        'icon' => 'fa fa-align-left',
                    ],
                    'right' => [
                        'title' => __( 'Right', 'droit-addons' ),
                        'icon' => 'fa fa-align-right',
                    ],
                ],
                'default' => 'left',
                'toggle' => true,
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_prev_nav_button_top_spacing',
            [
                'label' => __( 'Top', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .dl-slider-prev' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_prev_nav_button_left_spacing',
            [
                'label' => __( 'Left', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .dl-slider-prev' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_prev_nav_button_align' => ['left'],
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_prev_nav_button_right_spacing', 
            [
                'label' => __( 'Right', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 2000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .dl-slider-prev' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['absolute'],
                    'swiper_testimonial_prev_nav_button_align' => ['right'],
                ],
            ]
        );	

        $this->add_control(
            '_dl_testimonial_navigation_section',
            [
                'label' => __( 'Button', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'testimonial_btn_navigation_height',
            [
                'label' => __( 'Height', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 200,
                'step' => 1,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button' => 'height: {{VALUE}}px',
                ],
            ]
        );
        $this->add_responsive_control(
            'testimonial_btn_navigation_width',
            [
                'label' => __( 'Width', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 200,
                'step' => 1,
                'default' => 50,
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button' => 'width: {{VALUE}}px',
                ],
            ]
        );

        $this->add_responsive_control(
            'swiper_testimonial_navigation_button_Horizontal_spacing',
            [
                'label' => __( 'Horizontal Position', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['relative'],
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_navigation_button_Vartical_spacing',
            [
                'label' => __( 'Vartical Position', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -200,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_nav_button_icon_alignment' => ['relative'],
                ],
            ]
        );

        $this->add_control(
            'testimonial_btn_navigation_Typography_border_radius',
            [
                'label' => __( 'Border Radius', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'testimonial_btn_navigation_Typography',
            [
                'label' => __( 'Font Size', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button ' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonial_btn_navigation_Box_Shadow',
                'label' => __( 'Box Shadow', 'droit-addons' ),
                'selector' => '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button',
            ]
        );
        

        $this->start_controls_tabs(
            'testimonial_btn_navigation_style_tabs'
        );

        $this->start_controls_tab(
            'testimonial_btn_navigation_style_normal_tab',
            [
                'label' => __( 'Normal', 'droit-addons' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'testimonial_btn_navigation_background',
                'label' => __( 'Background', 'droit-addons' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'testimonial_btn_navigation_border',
                'label' => __( 'Border', 'droit-addons' ),
                'selector' => '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button',
            ]
        );
        $this->add_control(
            'testimonial_btn_navigation_icon_color',
            [
                'label' => __( 'Icon Color', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button' => 'color: {{VALUE}}'],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'testimonial_btn_navigation_style_hover_tab',
            [
                'label' => __( 'Hover', 'droit-addons' ),
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'testimonial_btn_navigation_hover_background',
                'label' => __( 'Background', 'droit-addons' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button:hover',
            ]
        );
        $this->add_control(
            'testimonial_btn_navigation_hover_icon_color',
            [
                'label' => __( 'Icon Color', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button:hover' => 'color: {{VALUE}}'],
            ]
        );
        $this->add_control(
            'testimonial_btn_navigation_hover_border',
            [
                'label' => __( 'Border Color', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => ['{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button:hover' => 'border-color: {{VALUE}}'],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'testimonial_btn_navigation_hover_Box_Shadow',
                'label' => __( 'Box Shadow', 'droit-addons' ),
                'selector' => '{{WRAPPER}} .dl_testimonial_swiper_navigation .swiper_testimonial_nav_button:hover',
            ]
        );


        $this->end_controls_tab();
        $this->end_controls_tabs();
        $this->end_controls_section();

        $this->start_controls_section(
            'testimonial_tab_pagination_style_section',
            [
                'label' => __( 'Pagination', 'droit-addons' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [ 'dl_testimonial_pagination' => 'yes']
            ]
        );

        $this->add_responsive_control(
            'swiper_testimonial_pagination_button_alignment_Position',
            [
                'label' => __( 'Position', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'relative'  => __( 'Normal', 'droit-addons' ),
                    'absolute' => __( 'absolute', 'droit-addons' ),
                    'fixed' => __( 'Fixed', 'droit-addons' ),
                ],
                'default' => 'relative',
                'selectors' => [
                    '{{wrapper}} .dl_swiper_testimonial_pagination' => 'position: {{VALUE}}'
                ],
            ]
        );

        $this->add_responsive_control(
            'swiper_testimonial_pagination_top_position',
            [
                'label' => __( 'Top', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 120,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_swiper_testimonial_pagination' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_pagination_button_alignment_Position' => ['absolute'],
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_pagination_left_position',
            [
                'label' => __( 'Left', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => -100,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_swiper_testimonial_pagination' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'swiper_testimonial_pagination_button_alignment_Position' => ['absolute'],
                ],
            ]
        );

        $this->add_control(
            '_dl_testimonial_slider_pagination_title',
            [
                'label' => __( 'Pagination', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_pagination_dot_alignment',
            [
                'label' => __( 'Pagination Alignment', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'label_block' => false,
                'default' => 'flex-start',
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'droit-addons'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'droit-addons'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'droit-addons'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_swiper_testimonial_pagination' => 'justify-content: {{VALUE}}',
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_pagination_button_Horizontal_spacing',
            [
                'label' => __( 'Horizontal Spacing', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:not(:first-child)' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'swiper_testimonial_pagination_button_Vartical_spacing',
            [
                'label' => __( 'Vartical Spacing', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 6,
                ],
                'selectors' => [
                    '{{WRAPPER}} .dl_swiper_testimonial_pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'testimonial_btn_pagination_border_radius',
            [
                'label' => __( 'Border Radius', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        

        $this->start_controls_tabs(
            'testimonial_tab_pagination_style_tabs'
        );

        $this->start_controls_tab(
            'testimonial_tab_pagination_style_normal_tab',
            [
                'label' => __( 'Normal', 'droit-addons' ),
            ]
        );
        
        $this->add_responsive_control(
            'testimonial_btn_pagination_height',
            [
                'label' => __( 'Height', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 200,
                'step' => 1,
                'default' => 10,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'height: {{VALUE}}px',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonial_btn_pagination_width',
            [
                'label' => __( 'Width', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 200,
                'step' => 1,
                'default' => 10,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{VALUE}}px',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'testimonial_btn_pagination_background',
                'label' => __( 'Background', 'droit-addons' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'testimonial_btn_pagination_border',
                'label' => __( 'Border', 'droit-addons' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'testimonial_tab_pagination_style_active_tab',
            [
                'label' => __( 'Active', 'droit-addons' ),
            ]
        );

        $this->add_responsive_control(
            'testimonial_btn_active_pagination_height',
            [
                'label' => __( 'Height', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 200,
                'step' => 1,
                'default' => 10,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'height: {{VALUE}}px',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonial_btn_active_pagination_width',
            [
                'label' => __( 'Width', 'droit-addons' ),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 0,
                'max' => 200,
                'step' => 1,
                'default' => 10,
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{VALUE}}px',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'testimonial_btn_active_pagination_background',
                'label' => __( 'Background', 'droit-addons' ),
                'types' => [ 'classic', 'gradient' ],
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'testimonial_btn_active_pagination_border',
                'label' => __( 'Border', 'droit-addons' ),
                'selector' => '{{WRAPPER}} .swiper-pagination-bullet.swiper-pagination-bullet-active',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
        do_action('dl_pro_testimonial_navigation', $this);
    }

    //Html render
    protected function render()
    {   
        $settings = $this->get_settings_for_display();
        extract($settings);
       
		$icon = '&#xE934;';
        
        $testimonial_id = $this->get_id();

        $testimonial_settings = [];
        $testimonial_settings['slidesPerView'] = $dl_testimonial_perpage;
        $testimonial_settings['loop'] = ($dl_testimonial_loop == 'yes') ? true : false;
        $testimonial_settings['speed'] = $dl_testimonial_speed;
		if( $dl_testimonial_autoplay == true){
            $testimonial_settings['autoplay']['delay'] = $dl_testimonial_auto_delay;
        } 
        
        $testimonial_settings['effect'] = $dl_testimonial_effect;
        $testimonial_settings['spaceBetween'] = $dl_testimonial_space;
        $testimonial_settings['slidesPerColumnFill'] = 'column';
        $testimonial_settings['centeredSlides'] = ($dl_testimonial_centered == 'no') ? false : true;
        $testimonial_settings['centeredSlides'] = ($dl_testimonial_centered == 'yes') ? true : false;
        $testimonial_settings['direction'] = ($dl_testimonial_direction == 'yes') ? 'vertical' : 'horizontal';
        if( $dl_testimonial_enable_slide_control == 'yes'){
            $testimonial_settings['navigation']['nextEl'] = '.dl-slider-next'.$testimonial_id;
            $testimonial_settings['navigation']['prevEl'] = '.dl-slider-prev'.$testimonial_id;
        }
        if( $dl_testimonial_pagination == 'yes'){
            $testimonial_settings['pagination']['el'] = '.dl_testimonial_pag'.$testimonial_id;
            $testimonial_settings['pagination']['type'] = $dl_testimonial_pagination_type;
            $testimonial_settings['pagination']['clickable'] = '!0';
        }
        if( $dl_breakpoints_enable == 'yes'){
            foreach($dl_breakpoints as $k=>$v){
                $width = $v['dl_breakpoints_width'];
                $testimonial_settings['breakpoints'][$width]['slidesPerView'] = $v['dl_breakpoints_perpage'];
                $testimonial_settings['breakpoints'][$width]['spaceBetween'] = $v['dl_breakpoints_space'];
                $testimonial_settings['breakpoints'][$width]['centeredSlides'] = $v['dl_breakpoints_center'];
            }
        }
        $testimonial_settings['dl_mouseover'] = ($dl_testimonial_mouseover_enable == 'yes') ? true : false;
        $testimonial_settings['dl_autoplay'] = $dl_testimonial_autoplay
       
        ?>
    
        <div class="dl_pro_testimonial_wrapper dl-slider-<?php echo esc_attr($testimonial_id);?>">  
            <div class="dl_pro_testimonial_slider swiper-container" data-settings='<?php echo json_encode($testimonial_settings, true);?>'>
                <div class="swiper-wrapper">
                    <?php if (isset($_dl_pro_testimonial_list) && !empty($_dl_pro_testimonial_list)):
                        foreach ($_dl_pro_testimonial_list as $item):
                            // image
                            $image = wp_get_attachment_image_url( $item['_dl_pro_testimonial_image']['id'], $this->get_pro_testimonials_settings('thumbnail_size') );
                            if ( ! $image ) {
                                $image = $item['_dl_pro_testimonial_image']['url'];
                            }
                    ?>
                      <div class="swiper-slide">
                        <div class="dl_pro_carousel_slider_wrapper">

                            <div class="dl_client_info">
                                <div class="dl_carousel_info_inner">
                                    <?php if ( !empty( $image ) ) : ?>
                                        <div class="dl-testimonial-reviewer">
                                            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $item['_dl_pro_testimonial_name'] ); ?>" class="dl_client_img">
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="dl-testimonial-content">
                                        <h5 class="dl_name"><?php echo __($item['_dl_pro_testimonial_name'], 'droit-addons'); ?></h5>
                                        <p class="dl_text">
                                            <?php echo $item['_dl_pro_testimonial_text']; ?>
                                        </p>
                                        
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php endforeach;
                endif;?>
                </div>
            </div>
            <?php if( $dl_testimonial_enable_slide_control == 'yes'){?>
            <div class="dl_testimonial_swiper_navigation">
                <div class="swiper_testimonial_nav_button dl-slider-prev dl-slider-prev<?php echo esc_attr($testimonial_id) ?>">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['dl_testimonial_nav_left_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
                <div class="swiper_testimonial_nav_button dl-slider-next dl-slider-next<?php echo esc_attr($testimonial_id) ?>">
                    <?php \Elementor\Icons_Manager::render_icon( $settings['dl_testimonial_nav_right_icon'], [ 'aria-hidden' => 'true' ] ); ?>
                </div>
            </div>
            <?php }
            
            if( $dl_testimonial_pagination == 'yes'){?>
            <div class="dl_swiper_testimonial_pagination dl_testimonial_pag<?php echo esc_attr($testimonial_id) ?>"></div>
            <?php } ?>
        </div>

        <?php
    }

    protected function content_template()
    {}
}
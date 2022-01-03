<?php
namespace DROIT_ELEMENTOR;

defined('ABSPATH') || die();

if (!class_exists('Dl_Tooltip')) {
    class Dl_Tooltip {

        private static $instance = null;

        public static function url(){
            if (defined('DROIT_ADDONS_FILE_')) {
                $file = trailingslashit(plugin_dir_url( DROIT_ADDONS_FILE_ )). 'modules/tooltip/';
            } else {
                $file = trailingslashit(plugin_dir_url( __FILE__ ));
            }
            return $file;
        }

        public static function dir(){
            if (defined('DROIT_ADDONS_FILE_')) {
                $file = trailingslashit(plugin_dir_path( DROIT_ADDONS_FILE_ )). 'modules/tooltip/';
            } else {
                $file = trailingslashit(plugin_dir_path( __FILE__ ));
            }
            return $file;
        }

        public static function version(){
            if( defined('DROIT_ADDONS_VERSION_') ){
                return DROIT_ADDONS_VERSION_;
            } else {
                return apply_filters('dladdons_pro_version', '1.0.0');
            }
        }

        public function init() {
            add_action( 'wp_enqueue_scripts', [ $this, 'load_assets' ] );
            add_action( 'elementor/element/common/_section_style/after_section_end', [ $this, 'tooltip_option' ], 99, 1 );
            add_action( 'elementor/preview/enqueue_scripts', [ $this, 'tooltip_render' ], 1 );
        }

        public function load_assets() {       
            wp_enqueue_style( "dl-tooltip-css", self::url() . 'assets/tooltip.css' , null, self::version() );  
            wp_enqueue_script("dl-tooltip-js", self::url() . 'assets/tooltip.min.js', ['jquery'], self::version(), true); 
        }

        public function tooltip_option( $data ) {
           
            $data->start_controls_section(
                'dl_tooltip_section',
                [
                    'label' => __( 'DL Tooltip', 'droit-elementor-addons' ) . dl_get_icon(),
                    'tab'   => \Elementor\Controls_Manager::TAB_ADVANCED,
                ]
            );

            $data->add_control(
                'dl_free_tooltip_enable',
                [
                    'label'              => __('Enable Droit Tooltip?', 'droit-addons'),
                    'type'               => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'           => __('On', 'droit-addons'),
                    'label_off'          => __('Off', 'droit-addons'),
                    'return_value'       => 'enable',
                    'prefix_class'       => 'dl-free-tooltip-',
                    'default'            => '',
                    'frontend_available' => true,
                ]
            );

            $data->start_controls_tabs( 'dl_tooltip_tabs' );

            $data->start_controls_tab( 'dl_tooltip_settings', [
                'label'     => __('Settings', 'droit-addons'),
                'condition' => [
                    'dl_free_tooltip_enable!' => '',
                ],
            ]);

            $data->add_control(
                'dl-free-tooltip-content',
                [
                    'label'     => __('Content', 'droit-addons'),
                    'type'      => \Elementor\Controls_Manager::TEXTAREA,
                    'rows' => 5,
                    'default'   => __('I am droit tooltip', 'droit-addons'),
                    'dynamic' => ['active' => true],
                    'frontend_available' => true,
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_responsive_control(
                'dl_free_tooltip_position',
                [
                    'label'              => __('Position', 'droit-addons'),
                    'type'               => \Elementor\Controls_Manager::SELECT,
                    'default'            => 'top',
                    'options'            => [
                            'top'            => __('Top', 'droit-addons'),
                            'bottom'         => __('Bottom', 'droit-addons'),
                            'left'           => __('Left', 'droit-addons'),
                            'right'          => __('Right', 'droit-addons'),
                    ],
                    'frontend_available' => true,
                    'prefix_class'       => 'dl-free-tooltip%s-',
                    'condition'          => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_control(
                'dl_free_tooltip_animation',
                [
                    'label' => esc_html__( 'Animation', 'elementor' ),
                    'type' => \Elementor\Controls_Manager::ANIMATION,
                    'frontend_available' => true,
                    'condition'          => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_control(
                'dl_free_tooltip_duration',
                [
                    'label'              => __('Animation Duration (ms)', 'droit-addons'),
                    'type'               => \Elementor\Controls_Manager::NUMBER,
                    'min'                => 100,
                    'max'                => 5000,
                    'step'               => 50,
                    'default'            => 1000,
                    'frontend_available' => true,
                    'condition'          => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_control(
                'dl_free_tooltip_arrow',
                [
                    'label'              => __('Arrow', 'droit-addons'),
                    'type'               => \Elementor\Controls_Manager::SWITCHER,
                    'label_on'           => __('Show', 'droit-addons'),
                    'label_off'          => __('Hide', 'droit-addons'),
                    'return_value'       => 'true',
                    'default'            => 'true',
                    'frontend_available' => true,
                    'condition'          => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_control(
                'dl_free_tooltip_trigger',
                [
                    'label'   => __('Trigger', 'droit-addons'),
                    'type'    => \Elementor\Controls_Manager::SELECT,
                    'default' => 'hover',
                    'options' => [
                        'click' => __('Click', 'droit-addons'),
                        'hover' => __('Hover', 'droit-addons'),
                    ],
                    'frontend_available' => true,
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_responsive_control(
                'dl_free_tooltip_distance',
                [
                    'label' => __('Spacing', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '0',
                    ],
                    'range' => [
                        'px' => [
                            'min' => -100,
                            'max' => 500,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} ' => 'dl-tooltip-arrow-spacing: {{SIZE}}{{UNIT}};',
                        
                    ],
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_responsive_control(
                'dl_free_tooltip_align',
                [
                    'label' => __('Text Alignment', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __('Left', 'droit-addons'),
                            'icon' => 'eicon-text-align-left',
                        ],
                        'center' => [
                            'title' => __('Center', 'droit-addons'),
                            'icon' => 'eicon-text-align-center',
                        ],
                        'right' => [
                            'title' => __('Right', 'droit-addons'),
                            'icon' => 'eicon-text-align-right',
                        ],
                    ],
                    'default' => 'center',
                    'toggle' => true,
                    'selectors' => [
                        '{{WRAPPER}} ' => 'text-align: {{VALUE}};'
                    ],
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->end_controls_tab();

            $data->start_controls_tab('dl_free_tooltip_styles', [
                'label'     => __('Styles', 'droit-addons'),
                'condition' => [
                    'dl_free_tooltip_enable!' => '',
                ],
            ]);

            $data->add_responsive_control(
                'dl_free_tooltip_width',
                [
                    'label'   => __('Width', 'droit-addons'),
                    'type'    => \Elementor\Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '120',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 800,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .dl-free-tooltip-content' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_responsive_control(
                'dl_free_tooltip_arrow_size',
                [
                    'label' => __('Tooltip Arrow Size (px)', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::SLIDER,
                    'default' => [
                        'size' => '5',
                    ],
                    'range' => [
                        'px' => [
                            'min' => 1,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .dl-free-tooltip-content::after' => 'border-width: {{SIZE}}{{UNIT}};',
                    ],
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                        'dl_free_tooltip_arrow' => 'true',
                    ],
                ]
            );

            $data->add_group_control(
                \Elementor\Group_Control_Typography::get_type(),
                [
                    'name' => 'dl_free_tooltip_typography',
                    'separator' => 'after',
                    'fields_options' => [
                        'typography' => [
                            'default' => 'yes'
                        ],
                        'font_family' => [
                            'default' => 'poppins',
                        ],
                        'font_weight' => [
                            'default' => '500', 
                        ],
                        'font_size' => [
                            'default' => [
                                'unit' => 'px', 
                                'size' => '14',
                            ],
                        ],
                    ],
                    'selector' => '{{WRAPPER}} .dl-free-tooltip-content',
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_group_control(
                \Elementor\Group_Control_Background::get_type(),
                [
                    'name'     => 'dl_free_tooltip_title_section_bg_color',
                    'label'    => __('Background', 'droit-addons'),
                    'types'    => ['classic', 'gradient'],
                    'selector' => '{{WRAPPER}} .dl-free-tooltip-content',
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                        'dl_free_tooltip_arrow!' => 'true',
                    ],
                ]
            );

            $data->add_control(
                'dl_free_tooltip_background_color',
                [
                    'label' => __('Background Color', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#222222',
                    'selectors' => [
                        '{{WRAPPER}} .dl-free-tooltip-content' => 'background: {{VALUE}};',
                        '{{WRAPPER}} .dl-free-tooltip-content::after' => 'dl-tooltip-arrow-color: {{VALUE}}',
                    ],
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                        'dl_free_tooltip_arrow' => 'true',
                    ],
                ]
            );

            $data->add_control(
                'dl_free_tooltip_color',
                [
                    'label' => __('Text Color', 'droit-addons'),
                    'type' => \Elementor\Controls_Manager::COLOR,
                    'default' => '#ffffff',
                    'selectors' => [
                        '{{WRAPPER}} .dl-free-tooltip-content' => 'color: {{VALUE}};',
                    ],
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_group_control(
                \Elementor\Group_Control_Border::get_type(),
                [
                    'name' => 'dl_free_tooltip_border',
                    'label' => __('Border', 'droit-addons'),
                    'selector' => '{{WRAPPER}} .dl-free-tooltip-content',
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                        'dl_free_tooltip_arrow!' => 'true',
                    ],
                ]
            );

            $data->add_responsive_control(
                'dl_free_tooltip_border_radius',
                [
                    'label'      => __('Border Radius', 'droit-addons'),
                    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .dl-free-tooltip-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_responsive_control(
                'dl_free_tooltip_padding',
                [
                    'label'      => __('Padding', 'droit-addons'),
                    'type'       => \Elementor\Controls_Manager::DIMENSIONS,
                    'size_units' => ['px', 'em', '%'],
                    'selectors'  => [
                        '{{WRAPPER}} .dl-free-tooltip-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->add_group_control(
                \Elementor\Group_Control_Box_Shadow::get_type(),
                [
                    'name' => 'dl_free_tooltip_box_shadow',
                    'selector' => '{{WRAPPER}} .dl-free-tooltip-content',
                    'separator' => '',
                    'condition' => [
                        'dl_free_tooltip_enable!' => '',
                    ],
                ]
            );

            $data->end_controls_tab();

            $data->end_controls_tabs();

            $data->end_controls_section();
         
        }

        public function tooltip_render() {

        }

        public static function instance() {

            if( is_null(self::$instance) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

    }
}

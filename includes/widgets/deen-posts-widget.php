<?php
/**
 * Class: Deen_Post_Layouts
 * Name: Deen Post Layouts
 * Slug: deen-post-layouts
 */

 // Elementor Classes

 use Elementor\Controls_Manager;
 use Elementor\Group_Control_Typography;
 use Elementor\Group_Control_Box_Shadow;
 use Elementor\Group_Control_Image_Size;
 use \Elementor\Group_Control_Css_Filter;
 
 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class Deen_Post_Layouts
 */

class Deen_Post_Layouts extends \Elementor\Widget_Base {

public function get_name() {
    return 'postsWidget';
}

public function get_title() {
    return esc_html__( 'Deen Posts', 'deen-post-layouts-addon' );
}

public function get_icon() {
    return 'eicon-posts-group';
}

public function get_categories() {
    return ['deen_post_layout_category'];
}

public function get_keywords() {
    return [ 'posts', 'links' ];
}

public function get_all_categories(){
	    $deen_options = array();
	    $deen_categories = get_categories() ;
	    foreach ( $deen_categories as $key => $deen_category ) {
		$deen_options[$deen_category->term_id] = $deen_category->name;
       }
       return $deen_options;
}
public function get_all_tags(){
	$deen_tag_options = array();
	$deen_tags = get_tags();
	foreach($deen_tags as $key=>$deen_tag){
		$deen_tag_options[$deen_tag->term_id] = $deen_tag->name;
	}
	return $deen_tag_options;
}

public function deen_allowed_tags(){
    
    $deen_allowed_html_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'dl' => array(),
		'dt' => array(),
		'em' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'i' => array(),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
		),
		'ol' => array(
			'class' => array(),
		),
		'p' => array(
			'class' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
		),
	);
	
	return $deen_allowed_html_tags;
}

protected function register_controls() {

	$this->start_controls_section(
		'deen_content_section',
		[
			'label' => esc_html__( 'Layout', 'deen-post-layouts-addon' ),
			'tab' => Controls_Manager::TAB_CONTENT,
		]
	);

   $this->add_control(
			'deen_post_style',
			[
				'label' => esc_html__( 'Skin', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::HIDDEN,
				'default' => 'classic',
			]
	);
	
	$this->add_control(
		'deen_image_position',
		[
			'label' => esc_html__( 'Image Position', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'top',
			'options' => [
				'top'  => esc_html__( 'Top', 'deen-post-layouts-addon' ),
				'left' => esc_html__( 'Left', 'deen-post-layouts-addon' ),
				'none' => esc_html__( 'None', 'deen-post-layouts-addon' ),
			],
			'conditions' => [
				'terms' => [
					[
					   'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
				],
			],
			
		]
	);


	$this->add_responsive_control(
		'deen_post_standard_columns',
		[
			'label' => esc_html__( 'Columns', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT,
			'default' => '3',
			'options' => [
				'1'  => esc_html__( '1', 'deen-post-layouts-addon' ),
				'2' => esc_html__( '2', 'deen-post-layouts-addon' ),
				'3' => esc_html__( '3', 'deen-post-layouts-addon' ),
				'4' => esc_html__( '4', 'deen-post-layouts-addon' ),
			],
			'selectors' => [
				'{{WRAPPER}} #deen-blog.deen-ft-posts .deen-left-area' => 'columns: {{VALUE}} !important',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style', 
						'operator' => 'in',
						'value' => ['classic'],
					],
				],
			],
		]
	);
	
	$this->add_control(
		'deen_post_per_page',
		[
			'label' => esc_html__( 'Posts Per Page', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::NUMBER,
			'min' => 1,
			'max' => 100,
			'step' => 1,
			'default' => 6,
		]
	);

	$this->add_group_control(
		Group_Control_Image_Size::get_type(),
		[
			'default' => 'large',
			'name' => 'thumbnails',
			'conditions' => [
				'terms' => [
					[
					   'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
					[
					   'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['none'],
					],
				],
			],
		]
	);

	$this->add_responsive_control(
		'deen_image_ratio',
		[
			'label' => esc_html__( 'Image Ratio', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 2,
					'step' => 0.1, 
				]
			],
			'default' => [
				'unit' => 'px', 
				'size' => 0.7,
			],
			'selectors' => [
				'{{WRAPPER}} a.deen-card-img-top img ' => 'aspect-ratio: 1/{{SIZE}}!important;',
			],
			'conditions' => [
				'terms' => [
				
					[
					   'name' => 'deen_image_position',
					   'operator' => '!=',
					   'value' => ['none'],
					],
				],
			],

		]
	);
    
	$this->add_control(
		'image_width',
		[
			'label' => esc_html__( 'Image Width', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SLIDER,
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
				'unit' => '%',
				'size' => 100,
			],
			'selectors' => [
				'{{WRAPPER}} .size-feature-thumb' => 'width: {{SIZE}}{{UNIT}} !important;',
				'{{WRAPPER}} .deen-hl-post .deen-img-overlay' => 'width: {{SIZE}}{{UNIT}} !important;',
				 '{{WRAPPER}} a.deen-card-img-top img' => 'width: {{SIZE}}{{UNIT}} !important;',
				'{{WRAPPER}} .deen-left-img' => 'width: {{SIZE}}{{UNIT}} !important;',
			],
			'conditions' => [
				'terms' => [
					[
					   'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
					[
					   'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['none'],
					],
				],
			],

		]
	);
	

    $this->add_control(
		'deen_show_title',
		[
			'label' => esc_html__( 'Title', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'deen-post-layouts-addon' ),
			'label_off' => esc_html__( 'Hide', 'deen-post-layouts-addon' ), 
			'return_value' => 'yes',
			'default' => 'yes',
			'separator' => 'before',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					]
				],
			],
			  
		]
	);

    $this->add_control(
		'deen_show_excerpt',
		[
			'label' => esc_html__( 'Excerpt', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'deen-post-layouts-addon' ),
			'label_off' => esc_html__( 'Hide', 'deen-post-layouts-addon' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'separator' => 'before',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => '==',
						'value' => 'classic',
					]
				],
			],
		]
	);

	$this->add_control(
		'deen_show_excerpt_length',
		[
			'label' => esc_html__( 'Excerpt Length', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::NUMBER,
			'min' => 5,
			'max' => 100,
			'step' => 1,
			'default' => 10,
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => '==',
						'value' => 'classic',
					],
					[
						'name' => 'deen_show_excerpt',
						'operator' => '==',
						'value' => 'yes',
					]
				],
			],
		]
	);

	$this->add_control(
		'deen_show_comments_number',
		[
			'label' => esc_html__( 'Comments', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'deen-post-layouts-addon' ),
			'label_off' => esc_html__( 'Hide', 'deen-post-layouts-addon' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'separator' => 'before',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
					[
					    'name' => 'deen_post_standard_columns',
					    'operator'=>'!=',
					    'value'=> '1'
					]
				],
			],
		]
	);
	
	
	$this->add_control(
		'deen_show_comments_number_column_one',
		[
			'label' => esc_html__( 'Comments', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'deen-post-layouts-addon' ),
			'label_off' => esc_html__( 'Hide', 'deen-post-layouts-addon' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'separator' => 'before',
			'conditions' => [
				'terms' => [
					[
					    'name' => 'deen_post_standard_columns',
					    'operator'=>'==',
					    'value'=> '1'
					]
				],
			],
		]
	);
	
	$this->add_control(
		'deen_show_meta_icon',
		[
			'label' => esc_html__( 'Show Meta Icon', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'deen-post-layouts-addon' ),
			'label_off' => esc_html__( 'Hide', 'deen-post-layouts-addon' ),
			'return_value' => 'yes',
			'default' => 'no',
			'separator' => 'before',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_standard_columns',
						'operator' => '==',
						'value' => '1',
					],
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					]
				],
			],
		]
	);

	$this->add_control(
		'deen_show_post_meta',
		[
			'label' => esc_html__( 'Meta Data', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT2,
			'multiple' => true,
			'options' => [
				'author'  => esc_html__( 'Author', 'deen-post-layouts-addon' ),
				'date' => esc_html__( 'Date', 'deen-post-layouts-addon' ),
			],
			'default' => [ 'author', 'date'],
			'separator' => 'before',
			'label_block' => true,
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
				],
			],
		]
	);

	$this->add_control(
		'deen_meta_separator_classic',
		[
			'label' => esc_html__( 'Separator', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( ' ', 'deen-post-layouts-addon' ),
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
				],
			],
		]
	);



	$this->add_control(
		'deen_show_read_more_btn',
		[
			'label' => esc_html__( 'Button', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'deen-post-layouts-addon' ),
			'label_off' => esc_html__( 'Hide', 'deen-post-layouts-addon' ),
			'return_value' => 'yes',
			'default' => 'yes',
			'separator'=>'before',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
				],
			],
		]
	);

	$this->add_control(
		'deen_read_more_btn_title',
		[
			'label' => esc_html__( 'Button Text', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( 'Read More', 'deen-post-layouts-addon' ),
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
					
					[
						'name' => 'deen_show_read_more_btn',
						'operator' => 'in',
						'value' => ['yes'],
					],
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					]
				],
			],
		]
	);

	$this->end_controls_section();

	$this->start_controls_section(
		'deen_query_section',
		[
			'label' => esc_html__( 'Query', 'deen-post-layouts-addon' ),
			'tab' => Controls_Manager::TAB_CONTENT,
		]
	);

	$this->add_control(
		'deen_post_qeury_order_by',
		[
			'label' => esc_html__( 'Order By', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'name',
			'options' => [
				'count'  => esc_html__( 'Count', 'deen-post-layouts-addon' ),
				'author' => esc_html__( 'Author', 'deen-post-layouts-addon' ),
				'ID' => esc_html__( 'ID', 'deen-post-layouts-addon' ),
				'name' => esc_html__( 'Name', 'deen-post-layouts-addon' ),
				'date' => esc_html__( 'Date', 'deen-post-layouts-addon' ),
				'title' => esc_html__( 'Title', 'deen-post-layouts-addon' ),	
				'none' => esc_html__( 'None', 'deen-post-layouts-addon' ),	
			],
		]
	);
	
	$this->add_control(
		'deen_gallery_post_tab_get_from',
		[
			'label' => esc_html__( 'Get Posts From', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'cat',
			'options' => [
				'cat'  => esc_html__( 'Categories', 'deen-post-layouts-addon' ),
				'tag' => esc_html__( 'Tags', 'deen-post-layouts-addon' ),
			],
		]
	);
    
	$this->add_control(
		'deen_query_using_cat_name',
		[
			'label' => esc_html__( 'Select Categories', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT2,
			'multiple' => true,
			'options' =>  $this->get_all_categories(),
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_gallery_post_tab_get_from',
						'operator' => '===',
						'value' => 'cat',
					],
				],
			],
		]
	);
	
	$this->add_control(
		'deen_query_using_tag_name',
		[
			'label' => esc_html__( 'Select Tags', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT2,
			'multiple' => true,
			'options' =>  $this->get_all_tags(),
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_gallery_post_tab_get_from',
						'operator' => '===',
						'value' => 'tag',
					],
				],
			],
		]
	);
	
	$this->add_control(
		'deen_show_tag',
		[
			'label' => esc_html__( 'Term', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SWITCHER,
			'label_on' => esc_html__( 'Show', 'deen-post-layouts-addon' ),
			'label_off' => esc_html__( 'Hide', 'deen-post-layouts-addon' ),
			'return_value' => 'yes',
			'default' => 'no',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],

					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['left'],
					]
				],
			],
			  
		]
	);
	


	$this->add_control(
		'deen_post_qeury_order',
		[
			'label' => esc_html__( 'Order', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'DESC',
			'options' => [
				'ASC'  => esc_html__( 'ASC', 'deen-post-layouts-addon' ),
				'DESC'  => esc_html__( 'DESC', 'deen-post-layouts-addon' ),
			],
		]
	);

    $this->end_controls_section();

	$this->start_controls_section(
		'deen_pagination_section',
		[
			'label' => esc_html__( 'Pagination', 'deen-post-layouts-addon' ),
			'tab' => Controls_Manager::TAB_CONTENT,
		]
	);

    $this->add_control(
		'deen_pagination_style',
		[
			'label' => esc_html__( 'Pagination', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SELECT,
			'default' => 'none',
			'options' => [
				'none'  => esc_html__( 'None', 'deen-post-layouts-addon' ),
				'prev_next' => esc_html__( 'Previous Next', 'deen-post-layouts-addon' ),
				'num_prev_next' => esc_html__( 'Number + Previous Next', 'deen-post-layouts-addon' ),
				'num' => esc_html__( 'Number', 'deen-post-layouts-addon' ),
			],
		]
	);

	$this->add_control(
		'deen_pagination_prev_title',
		[
			'label' => esc_html__( 'Previous Label', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( '« Previous Post — ', 'deen-post-layouts-addon' ),
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_pagination_style',
						'operator' => 'in',
						'value' => ['prev_next','num_prev_next'],
					],
				],
			],
		]
	);
	$this->add_control(
		'deen_pagination_next_title',
		[
			'label' => esc_html__( 'Next Label', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::TEXT,
			'default' => esc_html__( 'Next Post » ', 'deen-post-layouts-addon' ),
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_pagination_style',
						'operator' => 'in',
						'value' => ['prev_next','num_prev_next'],
					],
				],
			],
		]
	);

	$this->add_control(
		'deen_pagination_alignment',
		[
			'label' => esc_html__( 'Alignment', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::CHOOSE,
			'options' => [
				'left' => [
					'title' => esc_html__( 'Left', 'deen-post-layouts-addon' ),
					'icon' => 'eicon-text-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'deen-post-layouts-addon' ),
					'icon' => 'eicon-text-align-center',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'deen-post-layouts-addon' ),
					'icon' => 'eicon-text-align-right',
				],
			],
			'default' => 'center',
			'toggle' => true,
			'selectors'=>[
				'{{WRAPPER}} nav.elementor-pagination' => 'text-align: {{VALUE}} !important',
			]
		]
	);
	$this->end_controls_section();
	

     
    $this->end_controls_section();
    


    $this->start_controls_section(
		'deen_posts_style_section',
		[
			'label' => esc_html__( 'Layout', 'deen-post-layouts-addon' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]
	);

	$this->add_responsive_control(
		'deen_post_layout_style_column_gap',
		[
			'label' => esc_html__( 'Column Gap', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SLIDER,
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
			    'size'=>20,
				'unit' => 'px',
			],
			'selectors' => [
				'{{WRAPPER}} .deen-left-area' => 'column-gap:{{SIZE}}{{UNIT}} !important;', 
			],
			'conditions' => [
				'terms' => [
				
					[
						'name' => 'deen_post_standard_columns',
						'operator' => '!=',
						'value' => ['1'],
					],
				],
			],
		]
	);
	

	$this->add_responsive_control(
		'deen_post_layout_style_row_gap',
		[
			'label' => esc_html__( 'Row Gap', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SLIDER,
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
				'size' => 20,
			],
			'selectors' => [
				'{{WRAPPER}} .deen-standard-img-post' => 'margin-bottom:{{SIZE}}{{UNIT}} !important;', 
				'{{WRAPPER}} .deen-card.deen-standard-video' => 'margin-bottom:{{SIZE}}{{UNIT}} !important;',
			],

		]
	);
	
	$this->end_controls_section();


	$this->start_controls_section(
		'deen_post_box_style_section',
		[
			'label' => esc_html__( 'Box', 'deen-post-layouts-addon' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]
	);

	$this->add_control(
		'deen_post_box_border_width',
		[
			'label' => __( 'Border Width', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'range' => [
				'px' => [
					'min' => 0,
					'max' => 50,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .deen-standard-img-post' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
			],

		]
	);
	
	$this->add_control(
		'deen_posts_border_radius',
		[
			'label' => esc_html__( 'Border Radius', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SLIDER,
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
				'size' => 10,
			],
			'selectors' => [
				'{{WRAPPER}} #deen-blog .deen-card' => 'border-radius: {{SIZE}}{{UNIT}} !important;',
			],
			'conditions' => [
				'terms' => [
					[
					   'name' => 'deen_post_style',
						'operator' => 'in',
						'value' => ['classic'],
					],
				],
			],

		]
	);

	$this->add_responsive_control(
		'deen_post_box_padding',
		[
			'label' => __( 'Padding', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors' => [
				'{{WRAPPER}} .deen-standard-img-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
				'{{WRAPPER}} .deen-slide-div-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);
		
	
	$this->add_responsive_control(
		'deen_post_box_content_padding',
		[
			'label' => __( 'Content Padding', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors' => [
			    
				'{{WRAPPER}} .card-inner.deen-left-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				'{{WRAPPER}} .card-inner.deen-post-widget' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],

		]
	);

	$this->start_controls_tabs( 'deen_posts_box_normal_hover' );
	
    $this->start_controls_tab(
		'deen_post_box_normal',
		[
			'label' => esc_html__( 'Normal', 'deen-post-layouts-addon' ),

		]
	);

	$this->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'deen_post_box_box_shadow',
			'label' => esc_html__( 'Box Shadow', 'deen-post-layouts-addon' ),
			'selector' => '{{WRAPPER}} .deen-standard-img-post',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => '==',
						'value' => ['classic'],
					],
				],
			],
		]
	);

    $this->add_control(
		'deen_post_card_background_color',
		[
			'label' => esc_html__( 'Background Color', 'deen-post-layouts-addon' ), 
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} #deen-blog .deen-card' => 'background: {{VALUE}}',
				'{{WRAPPER}} .deen-gallery-card' => 'background-color: {{VALUE}}',
			],

		]
	);
	
	$this->add_control( 'deen_post_card_border_color',
	[   'label' => esc_html__( 'Border Color', 'deen-post-layouts-addon' ), 
	    'type' => Controls_Manager::COLOR, 
	    'selectors' => [ 
	    '{{WRAPPER}} .deen-standard-img-post' => 'border-color: {{VALUE}} !important', 
	 ], 
	]);

	$this->end_controls_tab();

	$this->start_controls_tab(
		'deen_post_box_hover',
		[
			'label' => esc_html__( 'Hover', 'deen-post-layouts-addon' ),

		]
	);

	$this->add_group_control(
		Group_Control_Box_Shadow::get_type(),
		[
			'name' => 'deen_post_box_box_shadow_hover',
			'label' => esc_html__( 'Box Shadow', 'deen-post-layouts-addon' ),
			'selector' => '{{WRAPPER}} .deen-standard-img-post:hover',
		]
	);
    $this->add_control(
		'deen_post_card_background_color_hover',
		[
			'label' => esc_html__( 'Background Color', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} #deen-blog .deen-card:hover' => 'background: {{VALUE}}',
			],

		]
	);
	$this->end_controls_tab();
	$this->end_controls_tabs(); 
	$this->end_controls_section();

	$this->start_controls_section(
		'deen_style_image_section',
		[
			'label' => esc_html__( 'Image', 'deen-post-layouts-addon' ),
			'tab' => Controls_Manager::TAB_STYLE,
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['none'],
					],
				],
			],
		]
	);
	
	$this->add_control(
			'deen_posts_left_image_radius',
			[
				'label' => esc_html__( 'Image Radius', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .deen-post-img.deen-left-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				
			]
	);
	
	$this->add_responsive_control(
		'deen_posts_image_spacing',
		[
			'label' => esc_html__( 'Spacing', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::SLIDER,
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
			],
			'selectors' => [
				'{{WRAPPER}} .size-feature-thumb' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				'{{WRAPPER}} .deen-hl-post .deen-img-overlay' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				'{{WRAPPER}} img' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
				],
			],
		]
	);

	$this->add_group_control(
	    Group_Control_Css_Filter::get_type(),
		[
			'name' => 'custom_posts_img_css_filters',
			'selector' => '{{WRAPPER}} img',
		]
	);

	$this->end_controls_section();


	$this->start_controls_section(
		'deen_style_content_section',
		[
			'label' => esc_html__( 'Content', 'deen-post-layouts-addon' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]
	); 


	$this->add_control(
		'deen_content_title_style',
		[
			'label' => esc_html__( 'Title', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::HEADING,
			'separator'=>'before',
		]
	);

	$this->add_control(
		'deen_posts_title_color',
		[
			'label' => esc_html__( 'Color', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}}  .card-inner h4.deen-post-title  a' => 'color: {{VALUE}} !important',
				'{{WRAPPER}} .deen-hl-post .deen-overlay-content h4' => 'color: {{VALUE}} !important',
				'{{WRAPPER}} .deen-post-title.deen-carousel-title a' => 'color: {{VALUE}} !important',
				'{{WRAPPER}} a p' => 'color: {{VALUE}} !important',
			],
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'deen_carousel_title_typography',
			'selector' => '{{WRAPPER}} h4.deen-post-title a',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => '==',
						'value' => 'classic',
					],
				],
			],
		]
	);
	
	$this->add_responsive_control(
			'deen_post_title_spacing',
			[
				'label' => esc_html__( 'Padding', 'deen-post-layouts-addon' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
				 '{{WRAPPER}} .deen-post-title' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				  '{{WRAPPER}} a p' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
			]
	);
	
	$this->add_control(
		'deen_content_meta_style',
		[
			'label' => esc_html__( 'Meta', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::HEADING,
			'separator'=>'before',
		]
	);

	$this->add_control(
		'deen_posts_meta_color',
		[
			'label' => esc_html__( 'Color', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .deen-post-author .span-style' => 'color: {{VALUE}} !important', 
				'{{WRAPPER}} .deen-post-author .span-style a' => 'color: {{VALUE}} !important',
				'{{WRAPPER}} .deen-post-author .span-style a' => 'color: {{VALUE}} !important',
				'{{WRAPPER}}  div.deen-time span' => 'color: {{VALUE}} !important',
				'{{WRAPPER}}  span.deen-widget-post-meta a' => 'color: {{VALUE}} !important',
			],

		]
	);
	
	$this->add_control(
		'deen_posts_meta_icon_color',
		[
			'label' => esc_html__( 'Icon Color', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} span.deen-icon-bg i' => 'color: {{VALUE}} !important', 
				'{{WRAPPER}} .fa-comment-dots:before' => 'color: {{VALUE}} !important',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_standard_columns',
						'operator' => '==',
						'value' => '1',
					],
				],
			],

		]
	);
	
	$this->add_control(
		'deen_posts_meta_background_color',
		[
			'label' => esc_html__( 'Icon Background', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} span.deen-icon-bg' => 'background: {{VALUE}} !important',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_standard_columns',
						'operator' => '==',
						'value' => '1',
					],
				],
			],

		]
	);
	
	$this->add_control(
			'deen_posts_meta_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::SLIDER,
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
					'size' => 14,
				],
				'selectors' => [
					'{{WRAPPER}} .deen-post-author.deen-post-widget' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_standard_columns',
						'operator' => '==',
						'value' => '1',
					],
				],
			     ],
			]
		);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'deen_posts_meta_typograaphy',
			'selector' => '{{WRAPPER}} span.deen-widget-post-meta  a',
		]
	);
	
    $this->add_responsive_control(
			'deen_post_meta_padding',
			[
				'label' => esc_html__( 'Margin', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .deen-post-author.deen-post-widget' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;', 
					'{{WRAPPER}} .deen-hl-post .deen-post-author' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => '!=',
						'value' => 'filter-tabs',
					],
				],
			],
			]
    );
    
    $this->add_control(
			'deen_posts_meta_separator_color',
			[
				'label' => esc_html__( 'Separator Color', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::COLOR,
				'separator'=>'before',
				'selectors' => [
					'{{WRAPPER}} span.deen-meta-separator' => 'color: {{VALUE}}',
				],
				'default'=>'#292929',
				'conditions' => [
	              'terms' => [
            		[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
	             ],
             ],
		]
	);
	
	$this->add_control(
		'deen_content_excerpt_style',
		[
			'label' => esc_html__( 'Excerpt', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::HEADING,
			'separator'=>'before',
		]
	);

	$this->add_control(
		'excerpt_title_color',
		[
			'label' => esc_html__( 'Color', 'deen-post-layouts-addon' ),
			'type' =>  Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} p.deen-post-excerpt.mb-25.deen-excerpt' => 'color: {{VALUE}}',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_post_style',
						'operator' => '!=',
						'value' => ['filter-tabs'],
					]
				],
			],
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'deen_post_excerpt_typography',
			'selector' => '{{WRAPPER}} p.deen-post-excerpt.mb-25.deen-excerpt',
		]
	);
	
	$this->add_responsive_control(
			'deen_post_excerpt_padding',
			[
				'label' => esc_html__( 'Padding', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} p.deen-post-excerpt.mb-25.deen-excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['none'],
					],
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['left'],
					],
				],
			],
		]
    );

	$this->add_control(
		'deen_content_read_more_style',
		[
			'label' => esc_html__( 'Button', 'deen-post-layouts-addon' ), 
			'type' => Controls_Manager::HEADING,
			'separator'=>'before',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
					[
						'name' => 'deen_show_read_more_btn',
						'operator' => '==',
						'value' => 'yes',
					],
				],
			],
		]
	);

	$this->add_control(
		'deen_post_read_more_color',
		[
			'label' => esc_html__( 'Color', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'default'=>'#292929',
			'selectors' => [
				'{{WRAPPER}} #deen-blog .deen-card .deen-post-footer a' => 'color: {{VALUE}} !important',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
					[
						'name' => 'deen_show_read_more_btn',
						'operator' => '==',
						'value' => 'yes',
					],
				],
			],
		]
	);

	$this->add_control(
		'deen_post_read_more_background',
		[
			'label' => esc_html__( 'Background', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button.deen-comment-btn.pl-20.pr-20.read-more' => 'background: {{VALUE}}',
				
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
					[
						'name' => 'deen_show_read_more_btn',
						'operator' => '==',
						'value' => 'yes',
					],
				],
			],
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'deen_posts_read_more_typography',
			'selector' => '{{WRAPPER}} .deen-comment-btn.read-more',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
					[
						'name' => 'deen_show_read_more_btn',
						'operator' => '==',
						'value' => 'yes',
					],
				],
			],
		]
	);

	$this->add_responsive_control(
			'deen_post_button_padding',
			[
				'label' => esc_html__( 'Padding', 'deen-post-layouts-addon' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
				 '{{WRAPPER}} .deen-comment-btn.read-more' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				 
				],
				'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => 'left',
					],
					[
						'name' => 'deen_show_read_more_btn',
						'operator' => '==',
						'value' => 'yes',
					],
				],
			],
			]
	);
   
   $this->add_control(
		'deen_content_comment_style',
		[
			'label' => esc_html__( 'Comment', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::HEADING,
			'separator'=>'before',
			'conditions' => [
            'terms' => [
            	[
					'name' => 'deen_image_position',
					'operator' => '!==',
					'value' => 'left',
				],
				[
					'name' => 'deen_show_comments_number',
					'operator' => '===',
					'value' => 'yes',
				],
            ],
            ],
		]
	);

	$this->add_control(
		'deen_post_comment_color',
		[
			'label' => esc_html__( 'Color', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} #deen-blog .deen-card .deen-post-footer span.span-style' => 'color: {{VALUE}} !important',
			],
			'default'=>'#292929',
			'conditions' => [
            'terms' => [
            	[
					'name' => 'deen_image_position',
					'operator' => '!==',
					'value' => 'left',
				],
				[
					'name' => 'deen_show_comments_number',
					'operator' => '===',
					'value' => 'yes',
				],
            ],
            ],
		]
	);
	
	$this->add_control(
		'deen_post_comment_btn_color',
		[
			'label' => esc_html__( 'Icon Color', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .fa-comment-dots:before' => 'color: {{VALUE}} !important',
			],
			'conditions' => [
            'terms' => [
            	[
					'name' => 'deen_image_position',
					'operator' => '!==',
					'value' => 'left',
				],
				[
					'name' => 'deen_show_comments_number',
					'operator' => '===',
					'value' => 'yes',
				],
            ],
            ],

		]
	);


	$this->add_control(
		'deen_post_comment_background_deen',
		[
			'label' => esc_html__( 'Background', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button.deen-comment-btn.pl-20.pr-20.deen-comment' => 'background-color: {{VALUE}} !important',
			],
			'conditions' => [
            'terms' => [
            	[
					'name' => 'deen_image_position',
					'operator' => '!==',
					'value' => 'left',
				],
				[
					'name' => 'deen_show_comments_number',
					'operator' => '===',
					'value' => 'yes',
				],
            ],
            ],
		]
	);
	
	$this->add_responsive_control(
			'deen_post_comment_button_padding',
			[
				'label' => esc_html__( 'Padding', 'deen-post-layouts-addon' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
				 '{{WRAPPER}} button.deen-comment-btn.pl-20.pr-20.deen-comment' => 'padding:{{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
				],
				'conditions' => [
            'terms' => [
            	[
					'name' => 'deen_image_position',
					'operator' => '!==',
					'value' => 'left',
				],
				[
					'name' => 'deen_show_comments_number',
					'operator' => '===',
					'value' => 'yes',
				],
            ],
            ],
			]
	);
  
	$this->add_control(
		'deen_content_category_style',
		[
			'label' => esc_html__( 'Term', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::HEADING, 
			'separator'=>'before',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['left'],
					],
				],
			],
		]
	);

	$this->add_control(
		'deen_post_category_color',
		[
			'label' => esc_html__( 'Color', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button.deen-primary-btn a' => 'color: {{VALUE}} !important',
				'{{WRAPPER}} button.deen-primary-btn.mb-15 a' => 'color: {{VALUE}} !important',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['left'],
					],
				],
			],
		]
	);

	$this->add_control(
		'deen_post_category_background_color',
		[
			'label' => esc_html__( 'Background', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} button.deen-primary-btn' => 'background-color: {{VALUE}} !important',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['left'],
					]
				],
			],
		]
	);

	$this->add_group_control(
		Group_Control_Typography::get_type(),
		[
			'name' => 'deen_posts_category_typography',
			'selector' => '{{WRAPPER}} button.deen-primary-btn',
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['left'],
					]
				],
			],
		]
    );
    
	$this->add_responsive_control(
		'deen_post_category_margin',
		[
			'label' => __( 'Margin', 'deen-post-layouts-addon' ),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors' => [
				'{{WRAPPER}} button.deen-primary-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
			],
			'conditions' => [
				'terms' => [
					[
						'name' => 'deen_image_position',
						'operator' => '!=',
						'value' => ['left'],
					]
				],
			],
		]
	);
    $this->end_controls_section();
    
    $this->start_controls_section(
		'deen_posts_pagination_section',
		[
			'label' => esc_html__( 'Pagination', 'deen-post-layouts-addon' ),
			'tab' => Controls_Manager::TAB_STYLE,
		]
	);
	
	$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'deen_posts_pagination_typography',
				'selector' => '{{WRAPPER}} nav.elementor-pagination',
			]
	);
	
	$this->start_controls_tabs( 'deen_posts_pagination_color_tabs' );
	
	$this->start_controls_tab(
		'deen_posts_pagination_normal',
		[
			'label' => esc_html__( 'Normal', 'deen-post-layouts-addon' ),
		]
	);
	
	$this->add_control(
			'deen_posts_pagination_color',
			[
				'label' => esc_html__( ' Color', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.elementor-pagination a' => 'color: {{VALUE}}',
					'{{WRAPPER}} nav.elementor-pagination span.page-numbers.dots' => 'color: {{VALUE}}',
				],
			]
	);
	
	$this->end_controls_tab();
	
	$this->start_controls_tab(
		'deen_posts_pagination_hover',
		[
			'label' => esc_html__( 'Hover', 'deen-post-layouts-addon' ),
		]
	);
	$this->add_control(
			'deen_posts_pagination_hover_color',
			[
				'label' => esc_html__( 'Color', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.elementor-pagination a:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} nav.elementor-pagination span.page-numbers.dots:hover' => 'color: {{VALUE}}',
				],
			]
	);
	$this->end_controls_tab();
	
	$this->start_controls_tab(
		'deen_posts_pagination_active',
		[
			'label' => esc_html__( 'Active', 'deen-post-layouts-addon' ),
		]
	);
	
	$this->add_control(
			'deen_posts_pagination_active_color',
			[
				'label' => esc_html__( 'Color', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} nav.elementor-pagination span.page-numbers.current' => 'color: {{VALUE}}',
				],
			]
	);
	
	$this->end_controls_tab();
	
	$this->add_control(
			'deen_posts_pagination_spacing',
			[
				'label' => esc_html__( 'Spacing', 'deen-post-layouts-addon' ),
				'type' =>  Controls_Manager::SLIDER,
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
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} nav.elementor-pagination' => 'padding-top: {{SIZE}}{{UNIT}};',
				],
			]
		);
	
	$this->end_controls_section();
	
}

protected function render() {
 $settings = $this->get_settings_for_display();
 $prevText = $settings['deen_pagination_prev_title'];
 $nextText = $settings['deen_pagination_next_title'];
 if('classic' == $settings['deen_post_style']) { 
?>
<section id="deen-blog" class="deen-ft-posts">  
    <div class="deen-posts">
        <div class="deen-post-cards">
            <div class="deen-left-area <?php echo (esc_attr($settings['deen_image_position']) == "left") ? 'left-position' : ''; ?> <?php echo esc_attr($settings['deen_post_standard_columns']) == "1" ? 'column-1' : '' ?>" >
                <?php
				   $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
				   if($settings['deen_gallery_post_tab_get_from'] == 'cat')	{
					$args = array(
						'posts_per_page' => $settings['deen_post_per_page'],
						'order'=> $settings['deen_post_qeury_order'],
						'orderby'=> $settings['deen_post_qeury_order_by'],
						'cat'=> $settings['deen_query_using_cat_name'],
						'paged'=>$paged,
					);
				   } elseif( $settings['deen_gallery_post_tab_get_from'] == 'tag' ) {
						$args = array(
							'posts_per_page' => $settings['deen_post_per_page'],
							'order'=> $settings['deen_post_qeury_order'],
							'orderby'=> $settings['deen_post_qeury_order_by'],
							'tag__in'=> $settings['deen_query_using_tag_name'],
							'paged'=>$paged,
						);
				   }
				   $query = new WP_query($args);
			       while ( $query->have_posts() ) {
				   $query->the_post();   
				   $settings['thumbnails'] = [
					   'id' => get_post_thumbnail_id(),
				   ];
				   $thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnails' );
				?>
                <div class="deen-card <?php echo ( esc_attr(get_post_format()) == 'video' && 'none' != esc_attr($settings['deen_image_position']) ) ? 'deen-standard-video' : 'deen-standard-img-post' ;  ?>"> 
				<div class="deen-post-img <?php echo ( esc_attr($settings['deen_image_position']) == 'left' ) ? 'deen-left-img' : ''; ?>">
                        <?php 
						 if(!has_post_thumbnail()){
					    ?>
							<a href="<?php esc_url(the_permalink()); ?>"
								class="deen-card-img-top <?php echo ( esc_attr($settings['deen_image_position'] ) == 'none') ? 'deen-thumbnail-display' : '' ;  ?>">
								<img src="<?php echo esc_url( plugins_url( '../../assets/img/placeholder.png', __FILE__ )) ; ?>" alt="default-image">
							</a>
                        <?php
						 }else{
						 ?>
							<a href="<?php esc_url(the_permalink()); ?>"
								class="deen-card-img-top <?php  echo ( esc_attr($settings['deen_image_position'] == 'none' )) ? 'deen-thumbnail-display' : '' ; ?>">
								<?php echo wp_kses($thumbnail_html, $this->deen_allowed_tags()); ?> 
							</a>
                        <?php
						 if( get_post_format() == 'video' && 'none'!= $settings['deen_image_position']) {
						?>
							<a href="<?php the_permalink(); ?>" class="play-img popup-youtube">
								<img src="<?php echo esc_url( plugins_url( '../../assets/img/video.png', __FILE__ )) ; ?>" alt="">
							</a>
						<?php
						 }
						?>
                        <?php
						 }
						?>
                        <?php 
                            if( isset($settings['deen_query_using_cat_name']) ) {
						     $categories = get_the_category();
							 $cat_ids = $settings['deen_query_using_cat_name'];
                             $user_given_categories = array();
                             if( $cat_ids != "" ) {
								foreach($cat_ids as $cat_id) {
									array_push($user_given_categories,get_cat_name($cat_id));
								}
                             }
                             $post_categories = array();
                             foreach($categories as $category) {
                                array_push($post_categories, $category->name);
                             }
                            $categoreis_collection = array_intersect($user_given_categories , $post_categories);
                            }elseif( isset($settings['deen_query_using_tag_name']) ) {
                            $tags = get_the_tags();
                            $tag_ids = $settings['deen_query_using_tag_name'] ?? "";
                            $user_given_tags = array();
                            foreach( $tag_ids as $tag_id ) {
                              array_push($user_given_tags, get_tag($tag_id)->name);
                            }
                            $post_tags = array();
							foreach( $tags as $tag) {
								array_push($post_tags, $tag->name );
							}
                            $tags_collection = array_intersect( $user_given_tags , $post_tags );
                            }
						?>
						<?php if( $settings['deen_image_position'] != 'left' && ( !empty($settings['deen_query_using_cat_name']) ||  !empty($settings['deen_query_using_tag_name'])  )){ ?>
                            <?php
								if($settings['deen_show_tag'] == 'yes'  && $settings['deen_image_position'] != 'left' ) {
							?>
                            <button  class="deen-primary-btn <?php echo ( esc_attr($settings['deen_image_position']) != 'none' && esc_attr($settings['deen_image_position']) != 'left' ) ?  'deen-post-category' : 'deen-no-img-cat' ; ?>">
                              <?php
                               if( $settings['deen_gallery_post_tab_get_from'] == 'cat' ) {
								$category_lists = array();
								foreach ( $categoreis_collection as $single_category ) {
									array_push($category_lists, '<a href="' . esc_url(get_category_link(get_cat_ID($single_category))) . '">' . $single_category  . '</a> ');
								}
								echo wp_kses(implode( ', ', $category_lists ), $this->deen_allowed_tags()); 
                              }elseif( $settings['deen_gallery_post_tab_get_from'] == 'tag' ) {
                                $tag_list = array();
								foreach ( $tags_collection as $single_tag ) {
									$tag = get_term_by('name', $single_tag, 'post_tag');
									array_push($tag_list, '<a href="' . esc_url(get_tag_link($tag->term_id)) . '">' . $single_tag  . '</a> ');
								}
                                echo wp_kses(implode( ', ', $tag_list ), $this->deen_allowed_tags());  
                              }
                              ?>
                            </button>
                            <?php
                            	}
                            ?>
                            <?php
							}else {
							 if( $settings['deen_show_tag'] == 'yes' && $settings['deen_image_position'] != 'left' ) {
							?>
							  <button class="deen-primary-btn  <?php echo ( esc_attr($settings['deen_image_position']) != 'none' && esc_attr($settings['deen_image_position']) != 'left') ?  'deen-post-category' : 'deen-no-img-cat' ; ?>">
							     <?php the_category(' , '); ?> 
							  </button>
							<?php
							 }
							}
							?> 
                    </div>

                    <div class="card-inner deen-post-widget <?php echo ( esc_attr($settings['deen_image_position'] ) == 'left') ? 'deen-left-card' : ' '; ?>">
                        <?php 
							if ( 'yes' == $settings['deen_show_title'] ) { 
						?>
                        <h4 class="deen-post-title">
                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        </h4>
                        <?php
					 		} 
					 	?>
                        <?php
						  if($settings['deen_show_post_meta']){
						?>
                        <div class="deen-post-author deen-post-widget <?php echo (esc_attr($settings['deen_image_position']) == 'left') ?  'deen-left-post-author' : ' '; ?>">
                            <?php
							 foreach( $settings['deen_show_post_meta'] as $item) {
							?>
                            <?php
							 if($item == "author") {
							?>
                            <div class="deen-author">
                                <?php 
									if('yes' == $settings['deen_show_meta_icon']) { 
								?>
									<span class="deen-icon-bg">
									<i class="far fa-user"></i>
									</span>&nbsp;
                                <?php
							 		} 
							 	?>
                                <span class="deen-widget-post-meta">
								 <?php the_author_posts_link();?> 
								</span>
                            </div>
                             <span class="deen-meta-separator">
                              <?php 
								 if(end($settings['deen_show_post_meta']) != $item ) {
									echo esc_html($settings['deen_meta_separator_classic']);	
								  }
							  ?>
							 </span>
                            <?php
							 }elseif( $item == "date" ) {
							?>
                            <div class="deen-date">
                                <?php
								 if('yes' == $settings['deen_show_meta_icon']) { 
								?>
                                <span class="deen-icon-bg">
                                  <i class="far fa-clock"></i>
                                </span>&nbsp;
                                <?php 
								} 
								?>
								<span class="deen-widget-post-meta">
								<a href="#">
									<?php
										echo esc_html(get_the_date('F j, Y'));
									?>
								</a>
							    </span>
                            </div>
                            <?php
							 } 
							?>
							<?php
							 }
							?>
							<?php 
								if( 'yes' == $settings['deen_show_comments_number_column_one'] ) { 
							?> 
							<div class="deen-comment">
							      <?php 
								  	if('yes' == $settings['deen_show_meta_icon']) { 
								  ?>
                                    <span class="deen-icon-bg">
                                        <i class="fas fa-comment-dots"></i>
                                    </span>&nbsp;
                                  <?php
									} 
								  ?>
                                    <span class="deen-widget-post-meta">
										<a href="#">
											<?php echo __('Comments ', 'deen-post-layouts-addon').esc_html(get_comments_number()) ; ?>
										</a>
									</span>
                            </div>
                            <?php
								} 
							?>
                        </div>
                        <?php
					     } 
					    ?>
                        <?php
						 if ( 'yes' == $settings['deen_show_excerpt'] ) {
						?>
                        <p class="deen-post-excerpt mb-25 deen-excerpt">
                            <?php echo wp_trim_words(get_the_excerpt(), esc_html($settings['deen_show_excerpt_length']) ); ?>
                        </p>
                        <?php
						 }
						?>
                       
                        <div class="deen-post-footer  deen-addon-btn <?php echo ( esc_attr($settings['deen_image_position']) == 'left' ) ? 'deen-left-post-footer' : ''; ?> <?php echo ( esc_attr($settings['deen_image_position']) == 'none') ? 'deen-none-post-footer' : ''; ?>">
                            <?php
							 if( 'yes' == $settings['deen_show_comments_number'] && 'left' != $settings['deen_image_position']) {
                            ?>
                            <button class="deen-comment-btn pl-20 pr-20 deen-comment">
                                <i class="fas fa-comment-dots danger-text"></i>
                                <span class="span-style ">
									<?php  echo esc_html(get_comments_number()); ?>
								</span>
                            </button>
                            <?php 
							  }
							?>
                            <?php
							 if(  'yes' == $settings['deen_show_read_more_btn'] && 'left' != $settings['deen_image_position']) {
							?>
							 <button class="deen-comment-btn pl-20 pr-20 read-more">
							 	<a href="<?php the_permalink(); ?>">
									<?php echo esc_html($settings['deen_read_more_btn_title']); ?>
								</a>
                             </button>
                            <?php
							} 
							?>
                        </div>
                    </div>
                </div>
                <?php
				 }
				 wp_reset_query();
				?>
            </div>
        </div>
    </div>
    <nav class="elementor-pagination" role="navigation" aria-label="Pagination">
	
		<?php

             if($settings['deen_pagination_style'] == 'prev_next'){
			   previous_posts_link(esc_html($prevText)); next_posts_link(esc_html($nextText) , $query->max_num_pages );
			 }elseif($settings['deen_pagination_style'] == 'num_prev_next'){
               echo wp_kses(paginate_links( array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $query->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'type'         => 'plain',
                'end_size'     => 2,
                'mid_size'     => 1,
                'prev_next'    => true,
                'prev_text'    => sprintf( '<i></i> %1$s', esc_html($prevText ) ),
                'next_text'    => sprintf( '%1$s <i></i>', esc_html($nextText ) ),
                'add_args'     => false,
                'add_fragment' => '',
             ) ), $this->deen_allowed_tags() );
			}elseif($settings['deen_pagination_style'] == 'num'){
			    echo wp_kses(paginate_links( array(
					'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
					'total'        => $query->max_num_pages,
					'current'      => max( 1, get_query_var( 'paged' ) ),
					'format'       => '?paged=%#%',
					'show_all'     => true,
					'type'         => 'plain',
					'end_size'     => 2,
					'mid_size'     => 1,
					'add_args'     => false,
					'add_fragment' => '',
					'prev_next'    => false,
				 ) ), $this->deen_allowed_tags());
		}
         ?>
    	</nav>
</section>

<?php
 }
 }
 }
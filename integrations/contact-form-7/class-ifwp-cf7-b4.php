<?php

if(!class_exists('IFWP_CF7_B4')){
    class IFWP_CF7_B4 {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // protected
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function floating_labels($tag = null, $fallback = true){
            if($tag->has_option('floating_labels')){
                $floating_labels = $tag->get_option('floating_labels', '', true);
                return ($floating_labels === 'false' ? false : boolval($floating_labels));
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function placeholder($tag = null, $fallback = ''){
            switch(true){
                case in_array($tag->basetype, ['text', 'email', 'url', 'tel']):
                    if($tag->has_option('placeholder') or $tag->has_option('watermark')){
                        if($tag->values){
                            return reset($tag->values);
                        }
                    }
                    break;
                case $tag->basetype == 'select':
                    if($tag->has_option('first_as_label')){
                        if($tag->values){
                            return reset($tag->values);
                        }
                    }
                    break;
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function select($tag = null){
            $html = wpcf7_select_form_tag_handler($tag);
            $html = str_get_html($tag);
            $floating_labels = self::floating_labels($tag);
            $placeholder = self::placeholder($tag);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $wrapper->addClass('ifwp-floating-labels');
                $select = $wrapper->find('select', 0);
                $select->addClass('custom-select');
                $option = $select->find('option', 0);
				$option->innertext = '';
                $select->outertext = $select->outertext . '<label>' . $placeholder . '</label>';
            } else {
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $select = $wrapper->find('select', 0);
                $select->addClass('custom-select');
                $size = self::size($tag);
                if($size){
                    $select->addClass('custom-select-' . $size);
                }
            }
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function size($tag = null, $fallback = ''){
            if($tag->has_option('ifwp_size')){
                $size = $tag->get_option('ifwp_size', '', true);
                if(in_array($size, ['sm', 'md', 'lg'])){
                    return ($size === 'md' ? '' : $size);
                }
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function text($tag = null){
            $html = wpcf7_text_form_tag_handler($tag);
            $html = str_get_html($tag);
            $floating_labels = self::floating_labels($tag);
            $placeholder = self::placeholder($tag);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $wrapper->addClass('ifwp-floating-labels');
                $input = $wrapper->find('input', 0);
                $input->addClass('form-control');
                $input->outertext = $input->outertext . '<label>' . $placeholder . '</label>';
            } else {
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $input = $wrapper->find('input', 0);
                $input->addClass('form-control');
                $size = self::size($tag);
                if($size){
                    $input->addClass('form-control-' . $size);
                }
            }
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function textarea($tag = null){
            $html = wpcf7_textarea_form_tag_handler($tag);
            $html = str_get_html($tag);
            $floating_labels = self::floating_labels($tag);
            $placeholder = self::placeholder($tag);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $wrapper->addClass('ifwp-floating-labels');
                $textarea = $wrapper->find('textarea', 0);
                $textarea->addClass('form-control');
                $textarea->cols = null;
				$textarea->rows = null;
                $textarea->outertext = $textarea->outertext . '<label>' . $placeholder . '</label>';
            } else {
                $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
                $textarea = $wrapper->find('textarea', 0);
                $textarea->addClass('form-control');
                $size = self::size($tag);
                if($size){
                    $textarea->addClass('form-control-' . $size);
                }
            }
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function enqueue_scripts(){
            wp_enqueue_script('ifwp-cf7-b4', plugin_dir_url(__FILE__) . 'ifwp-cf7-b4.js', ['contact-form-7'], filemtime(plugin_dir_path(__FILE__) . 'ifwp-cf7-b4.js'), true);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function init(){
            wpcf7_add_form_tag(['select', 'select*'], [__CLASS__, 'select'], [
        		'name-attr' => true,
                'selectable-values' => true,
        	]);
            wpcf7_add_form_tag(['text', 'text*', 'email', 'email*', 'url', 'url*', 'tel', 'tel*'], [__CLASS__, 'text'], [
        		'name-attr' => true,
        	]);
            wpcf7_add_form_tag(['textarea', 'textarea*'], [__CLASS__, 'textarea'], [
        		'name-attr' => true,
        	]);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}

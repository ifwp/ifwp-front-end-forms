<?php

if(!class_exists('IFWP_CF7_B4')){
    class IFWP_CF7_B4 {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // protected
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function browse($tag = null, $fallback = ''){
			if($tag->has_option('ifwp_browse')){
                return $tag->get_option('ifwp_browse', '', true);
            }
            if(!$fallback){
                $fallback = __('Select');
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function checkbox($html = '', $tag = null){
            $html = str_get_html($html);
			$type = (in_array($tag->basetype, ['checkbox', 'radio']) ? $tag->basetype : 'checkbox');
			foreach($html->find('.wpcf7-list-item') as $li){
				$li->addClass('custom-control custom-' . $type);
				if(self::inline($tag)){
                    $li->addClass('custom-control-inline');
                }
				$input = $li->find('input', 0);
				$input->addClass('custom-control-input');
				$input->id = $tag->name . '_' . sanitize_title($input->value);
				$label = $li->find('.wpcf7-list-item-label', 0);
				$label->addClass('custom-control-label');
				$label->for = $input->id;
				$label->tag = 'label';
				$li->innertext = $input->outertext . $label->outertext;
			}
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function file($html = '', $tag = null){
            $html = str_get_html($html);
            $wrapper = $html->find('.wpcf7-form-control-wrap', 0);
            $wrapper->addClass('custom-file');
            $input = $wrapper->find('input', 0);
            $input->addClass('custom-file-input');
			$input->id = $tag->name;
            $input->outertext = $input->outertext . '<label class="custom-file-label" for="' . $input->id . '" data-browse="' . self::browse($tag) . '">' . self::label($tag) . '</label>';
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function floating_labels($tag = null, $fallback = true){
            if($tag->has_option('floating_labels')){
                $floating_labels = $tag->get_option('floating_labels', '', true);
				return (in_array($floating_labels, ['off', 'false']) ? false : boolval($floating_labels));
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function inline($tag = null, $fallback = false){
            if($tag->has_option('inline')){
                $inline = $tag->get_option('inline', '', true);
				return (in_array($inline, ['off', 'false']) ? false : boolval($inline));
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function label($tag = null, $fallback = ''){
			if($tag->has_option('ifwp_label')){
                return $tag->get_option('ifwp_label', '', true);
            }
            if(!$fallback){
                $fallback = __('Select Files');
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function placeholder($tag = null, $fallback = ''){
            switch(true){
                case in_array($tag->basetype, ['text', 'email', 'url', 'tel', 'textarea']):
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

        protected static function select($html = '', $tag = null){
            $html = str_get_html($html);
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

        protected static function text($html = '', $tag = null){
            $html = str_get_html($html);
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

        protected static function textarea($html = '', $tag = null){
            $html = str_get_html($html);
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
            wp_enqueue_style('ifwp-cf7-b4', plugin_dir_url(__FILE__) . 'ifwp-cf7-b4.css', ['contact-form-7'], filemtime(plugin_dir_path(__FILE__) . 'ifwp-cf7-b4.css'));
			wp_enqueue_script('ifwp-cf7-b4', plugin_dir_url(__FILE__) . 'ifwp-cf7-b4.js', ['contact-form-7'], filemtime(plugin_dir_path(__FILE__) . 'ifwp-cf7-b4.js'), true);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function init(){
			 wpcf7_add_form_tag('acceptance', function($tag){
                $html = wpcf7_acceptance_form_tag_handler($tag);
                return self::checkbox($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
            wpcf7_add_form_tag(['checkbox', 'checkbox*', 'radio', 'radio*'], function($tag){
                $html = wpcf7_checkbox_form_tag_handler($tag);
                return self::checkbox($html, $tag);
            }, [
        		'name-attr' => true,
                'selectable-values' => true,
				'multiple-controls-container' => true,
        	]);
			wpcf7_add_form_tag(['date', 'date*'], function($tag){
                $html = wpcf7_date_form_tag_handler($tag);
                return self::text($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
			wpcf7_add_form_tag(['file', 'file*'], function($tag){
                $html = wpcf7_file_form_tag_handler($tag);
                return self::file($html, $tag);
            }, [
        		'name-attr' => true,
                'file-uploading' => true,
        	]);
			wpcf7_add_form_tag(['number', 'number*'], function($tag){
                $html = wpcf7_number_form_tag_handler($tag);
				return self::text($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
			wpcf7_add_form_tag(['range', 'range*'], function($tag){
                return wpcf7_number_form_tag_handler($tag);
            }, [
        		'name-attr' => true,
        	]);
			wpcf7_add_form_tag(['select', 'select*'], function($tag){
                $html = wpcf7_select_form_tag_handler($tag);
                return self::select($html, $tag);
            }, [
        		'name-attr' => true,
                'selectable-values' => true,
        	]);
            wpcf7_add_form_tag(['text', 'text*', 'email', 'email*', 'url', 'url*', 'tel', 'tel*'], function($tag){
                $html = wpcf7_text_form_tag_handler($tag);
                return self::text($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
            wpcf7_add_form_tag(['textarea', 'textarea*'], function($tag){
                $html = wpcf7_textarea_form_tag_handler($tag);
                return self::textarea($html, $tag);
            }, [
        		'name-attr' => true,
        	]);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}

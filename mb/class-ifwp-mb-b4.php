<?php

if(!class_exists('IFWP_MB_B4')){
    class IFWP_MB_B4 {

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // protected
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function btn($field = [], $fallback = 'primary'){
            if(isset($field['ifwp_btn']) and $field['ifwp_btn']){
                if(in_array($field['ifwp_btn'], ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark', 'link', 'outline-primary', 'outline-secondary', 'outline-success', 'outline-danger', 'outline-warning', 'outline-info', 'outline-light', 'outline-dark'])){
                    return $field['ifwp_btn'];
                }
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function block($field = [], $fallback = false){
            if(isset($field['ifwp_block'])){
                return ($field['ifwp_block'] === 'false' ? false : boolval($field['ifwp_block']));
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function browse($field = [], $fallback = ''){
            if(isset($field['ifwp_browse']) and $field['ifwp_browse']){
                return $field['ifwp_browse'];
            }
            if(!$fallback){
                $fallback = __('Select');
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function checkbox($html = '', $field = []){
            $html = str_get_html($html);
            $wrapper = $html->find('.rwmb-input', 0);
            $wrapper->addClass('custom-control custom-checkbox');
            $label = $wrapper->find('label', 0);
            $label->addClass('custom-control-label');
            $input = $label->find('input', 0);
            $input->addClass('custom-control-input');
            $label->for = $input->id;
            $label->innertext = $label->plaintext;
            $label->outertext = $input . $label->outertext;
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function file($html = '', $field = []){
            $html = str_get_html($html);
            $wrapper = $html->find('.rwmb-file-new', 0);
            $wrapper->addClass('custom-file');
            $input = $wrapper->find('input', 0);
            $input->addClass('custom-file-input');
            $input->outertext = $input->outertext . '<label class="custom-file-label" for="' . $input->id . '" data-browse="' . self::browse($field) . '">' . self::label($field) . '</label>';
            $html = self::maybe_parse_description($html);
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function floating_labels($field = [], $fallback = true){
            if(isset($field['floating_labels'])){
                return ($field['floating_labels'] === 'false' ? false : boolval($field['floating_labels']));
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function id($field = [], $fallback = ''){
            if(isset($field['id']) and $field['id']){
                return $field['id'];
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function label($field = [], $fallback = ''){
            if(isset($field['ifwp_label']) and $field['ifwp_label']){
                return $field['ifwp_label'];
            }
            if(!$fallback){
                $fallback = __('Select Files');
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function list($type = '', $html = '', $field = []){
            $html = str_get_html($html);
            if($type == 'checkbox'){
                $button = $html->find('button', 0);
            	if($button){
                    $btn = self::btn($field, 'outline-secondary');
            		$button->addClass('btn btn-' . $btn);
                    if(self::block($field)){
                        $button->addClass('btn-block');
                    }
                    $size = self::size($field, 'sm');
                    if($size){
                        $button->addClass('btn-' . $size);
                    }
            	}
            }
            $ul = $html->find('.rwmb-input-list', 0);
            $ul->addClass('pl-0');
            foreach($ul->find('li') as $li){
                $li->addClass('custom-control custom-' . $type);
                if(isset($field['inline']) and $field['inline']){
                    $li->addClass('custom-control-inline');
                }
                $label = $li->find('label', 0);
                $label->addClass('custom-control-label');
                $input = $label->find('input', 0);
                $input->addClass('custom-control-input');
                $input->id = $field['id'] . '_' . sanitize_title($input->value);
                $label->for = $input->id;
                $label->innertext = $label->plaintext;
                $label->outertext = $input . $label->outertext;
            }
            $html = self::maybe_parse_description($html);
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function maybe_parse($html = '', $field = []){
            if(isset($field['type'])){
                switch($field['type']){
                    case 'checkbox':
                        $html = self::checkbox($html, $field);
                        break;
                    case 'checkbox_list':
                        $html = self::list('checkbox', $html, $field);
                        break;
                    case 'file':
                        $html = self::file($html, $field);
                        break;
                    case 'post':
                    case 'taxonomy':
                    case 'taxonomy_advanced':
                    case 'user':
                        if(isset($field['field_type'])){
                            switch($field['field_type']){
                                case 'checkbox':
                                case 'radio':
                                    $html = self::list($field['field_type'], $html, $field);
                                    break;
                                case 'select':
                                    $html = self::select($html, $field);
                                    break;
                            }
                        }
                        break;
                    case 'radio':
                        $html = self::list('radio', $html, $field);
                        break;
                    case 'select':
                        $html = self::select($html, $field);
                        break;
                    case 'text':
                    case 'email':
                    case 'number':
                    case 'password':
                    case 'url':
                        $html = self::text($html, $field);
                        break;
                    case 'textarea':
                        $html = self::textarea($html, $field);
                        break;
                }
            }
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function maybe_parse_description($html = ''){
            $description = $html->find('.description', 0);
            if($description){
                $description->addClass('small form-text text-muted mb-0');
            }
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function overwrite($handle = '', $src = '', $deps = [], $ver = false, $in_footer = false){
            if(wp_script_is($handle)){
                wp_dequeue_script($handle);
            }
            if(wp_script_is($handle, 'registered')){
                wp_deregister_script($handle);
            }
            wp_register_script($handle, $src, $deps, $ver, $in_footer);
            wp_enqueue_script($handle);
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function placeholder($field = [], $fallback = ''){
            if(isset($field['placeholder']) and $field['placeholder']){
                return $field['placeholder'];
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function select($html = '', $field = []){
            $html = str_get_html($html);
            $floating_labels = self::floating_labels($field);
            $placeholder = self::placeholder($field);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.rwmb-input', 0);
                $wrapper->addClass('ifwp-floating-labels');
                $select = $wrapper->find('select', 0);
                $select->addClass('custom-select mw-100');
                $option = $select->find('option', 0);
                $option->innertext = '';
                $select->outertext = $select->outertext . '<label>' . $field['placeholder'] . '</label>';
            } else {
                $wrapper = $html->find('.rwmb-input', 0);
                $select = $wrapper->find('select', 0);
                $select->addClass('custom-select mw-100');
                $size = self::size($field);
                if($size){
                    $input->addClass('form-control-' . $size);
                }
            }
            $html = self::maybe_parse_description($html);
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function size($field = [], $fallback = ''){
            if(isset($field['ifwp_size']) and $field['ifwp_size']){
                if(in_array($field['ifwp_size'], ['sm', 'md', 'lg'])){
                    return ($field['ifwp_size'] === 'md' ? '' : $field['ifwp_size']);
                }
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function submit_class($config = [], $fallback = 'btn btn-primary'){
            if(isset($config['id']) and $config['id']){
                $btn = 'primary';
                $block = false;
                $size = '';
        		$meta_boxes = [];
        		$meta_box_ids = array_filter(explode(',', $config['id'] . ','));
        		foreach($meta_box_ids as $meta_box_id){
        			$meta_boxes[] = rwmb_get_registry('meta_box')->get($meta_box_id);
        		}
        		$meta_boxes = array_filter($meta_boxes);
        		if($meta_boxes){
        			foreach($meta_boxes as $meta_box){
                        $btn = self::btn($meta_box->meta_box);
                        $block = self::block($meta_box->meta_box);
                        $size = self::size($meta_box->meta_box);
        			}
        		}
                $class = 'btn btn-' . $btn;
                if($block){
                    $class .= ' btn-block';
                }
                if($size){
                    $class .= ' btn-' . $size;
                }
                return $class;
            }
            return $fallback;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function text($html = '', $field = []){
            $html = str_get_html($html);
            $floating_labels = self::floating_labels($field);
            $placeholder = self::placeholder($field);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.rwmb-input', 0);
                $wrapper->addClass('ifwp-floating-labels');
                $input = $wrapper->find('input', 0);
                $input->addClass('form-control mw-100');
                $input->outertext = $input->outertext . '<label>' . $placeholder . '</label>';
            } else {
                $wrapper = $html->find('.rwmb-input', 0);
                $input = $wrapper->find('input', 0);
                $input->addClass('form-control mw-100');
                $size = self::size($field);
                if($size){
                    $input->addClass('form-control-' . $size);
                }
            }
            $html = self::maybe_parse_description($html);
            return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        protected static function textarea($html = '', $field = []){
            $html = str_get_html($html);
            $floating_labels = self::floating_labels($field);
            $placeholder = self::placeholder($field);
            if($floating_labels and $placeholder){
                $wrapper = $html->find('.rwmb-input', 0);
                $wrapper->addClass('ifwp-floating-labels');
                $textarea = $wrapper->find('textarea', 0);
                $textarea->addClass('form-control mw-100');
                $textarea->cols = null;
                $textarea->rows = null;
                $textarea->outertext = $textarea->outertext . '<label>' . $placeholder . '</label>';
            } else {
                $wrapper = $html->find('.rwmb-input', 0);
                $textarea = $wrapper->find('textarea', 0);
                $textarea->addClass('form-control mw-100');
                $size = self::size($field);
                if($size){
                    $input->addClass('form-control-' . $size);
                }
            }
            $html = self::maybe_parse_description($html);
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        //
        // public
        //
        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function after_submit_button($config){
            $html = ob_get_clean();
            if(!is_admin()){
                $html = str_get_html($html);
                $button = $html->find('.rwmb-button', 0);
                $button->addClass(self::submit_class($config));
            }
            echo $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function before_submit_button($config){
            ob_start();
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function enqueue_scripts(){
            if(!is_admin()){
                wp_enqueue_style('ifwp-mb-b4-columns', plugin_dir_url(__FILE__) . 'ifwp-mb-b4-columns.css', ['rwmb-columns'], filemtime(plugin_dir_path(__FILE__) . 'ifwp-mb-b4-columns.css'));
                wp_enqueue_style('ifwp-mb-b4-form', plugin_dir_url(__FILE__) . 'ifwp-mb-b4-form.css', ['mbfs-form'], filemtime(plugin_dir_path(__FILE__) . 'ifwp-mb-b4-form.css'));
                wp_enqueue_style('ifwp-mb-b4-styles', plugin_dir_url(__FILE__) . 'ifwp-mb-b4-styles.css', ['rwmb'], filemtime(plugin_dir_path(__FILE__) . 'ifwp-mb-b4-styles.css'));
                wp_enqueue_style('select2-bootstrap', plugin_dir_url(__FILE__) . 'select2-bootstrap.min.css', ['rwmb-select2'], '1.0.0');
                self::overwrite('rwmb-select2', 'https://cdn.jsdelivr.net/npm/select2@4.0.10/dist/js/select2.full.min.js', ['jquery'], '4.0.10', true);
                wp_enqueue_script('jquery-validation-messages-es', 'https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/localization/messages_es.min.js', ['rwmb-validation'], '1.19.3', true);
            }
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function normalize_field($field){
            if(!is_admin()){
                if(isset($field['type'])){
                    $normalize = false;
                    switch($field['type']){
                        case 'checkbox':
                        case 'checkbox_list':
                        case 'email':
                        case 'number':
                        case 'password':
                        case 'radio':
                        case 'select':
                        case 'text':
                        case 'textarea':
                        case 'url':
                            $normalize = true;
                            break;
                        case 'post':
                        case 'taxonomy':
                        case 'taxonomy_advanced':
                        case 'user':
                            if(isset($field['field_type'])){
                                switch($field['field_type']){
                                    case 'checkbox':
                                    case 'radio':
                                    case 'select':
                                        $normalize = true;
                                        break;
                                }
                            }
                            break;
                    }
                    if($normalize){
                        if(isset($field['clone']) and $field['clone']){
                            $field['clone'] = false;
                        }
                    }
                    if($field['type'] == 'file'){
                        $field['max_file_uploads'] = 1;
                    }
                    if($field['type'] == 'select_advanced'){
                        $field['js_options']['theme'] = 'bootstrap';
                        $size = self::size($field);
                        if($size){
                            $field['js_options']['containerCssClass'] = 'form-control-' . $size;
                        }
                    }
                }
            }
			return $field;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

        public static function outer_html($html, $field){
            if(!is_admin()){
                if(self::id($field)){
                    $html = self::maybe_parse($html, $field);
                }
            }
        	return $html;
        }

        // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    }
}

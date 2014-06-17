<?php

class CleartextComponent extends Component {

    public function cleanstring($string, $source = 'Page', $id = false) {
        static $strings = array();
        // Empty strings do not need any proccessing.
        if ($string === '' || $string === NULL) {
            return '';
        }

        // Check if the string has already been processed, and if so return the
        // cached result.
        if (isset($strings[$string])) {
            return $strings[$string];
        }

        // Remove all HTML tags from the string.
        $output = strip_tags(html_entity_decode($string));
        $output = preg_replace("/[^a-z0-9\-\s]/i", " ", $output);

        // Replace or drop punctuation based on user settings
        $separator = '-';

        // Calculate and statically cache the ignored words regex expression.
        static $ignore_words_regex;

        $ignore_words = array(
            'a', 'an', 'as', 'at', 'before', 'but', 'by', 'for', 'from', 'is', 'in',
            'into', 'like', 'of', 'off', 'on', 'onto', 'per', 'since', 'than', 'the',
            'this', 'that', 'to', 'up', 'via', 'with',
        );

        $ignore_words_regex = preg_replace(array('/^[,\s]+|[,\s]+$/', '/[,\s]+/'), array('', '\b|\b'), $ignore_words);
        if ($ignore_words_regex) {
            @$ignore_words_regex = '\b' . $ignore_words_regex . '\b';
        }


        // Get rid of words that are on the ignore list
        if ($ignore_words_regex) {
            if (function_exists('mb_eregi_replace')) {
                $words_removed = mb_eregi_replace($ignore_words_regex, '', $output);
            } else {
                $words_removed = preg_replace("/$ignore_words_regex/i", '', $output);
            }
            if (strlen(trim($words_removed)) > 0) {
                $output = $words_removed;
            }
        }

        // Always replace whitespace with the separator.
        $output = preg_replace('/\s+/', $separator, $output);

        // Trim duplicates and remove trailing and leading separators.
        $output = $this->_pathauto_clean_separators($output);

        // Optionally convert to lower case.

        $output = strtolower($output);


        // Enforce the maximum component length.
        $maxlength = 100;
        $output = substr($output, 0, $maxlength);
	
	
	$output = $this->_pathauto_check_exists($output, $source, $id);
	
        // Cache this result in the static array.
        $strings[$string] = $output;
        return $output;
    }

    function _pathauto_clean_separators($string, $separator = NULL) {
        $output = $string;

        if (!isset($separator)) {
            $separator = '';
        }

        // Clean duplicate or trailing separators.
        if (strlen($separator)) {
            // Escape the separator.
            $seppattern = preg_quote($separator, '/');

            // Trim any leading or trailing separators.
            $output = preg_replace("/^$seppattern+|$seppattern+$/", '', $output);

            // Replace trailing separators around slashes.
            if ($separator !== '/') {
                $output = preg_replace("/$seppattern+\/|\/$seppattern+/", "/", $output);
            }

            // Replace multiple separators with a single one.
            $output = preg_replace("/$seppattern+/", $separator, $output);
        }

        return $output;
    }
    
    function _pathauto_check_exists($alias, $source, $id = false){
	  if ($this->_pathauto_alias_exists($alias, $source, $id)) {
	    $maxlength = 100;
	    $separator = '-';
	    $original_alias = $alias;

	    $i = 0;
	    do {
	    // Append an incrementing numeric suffix until we find a unique alias.
	    $unique_suffix = $separator . $i;
	    $alias = substr($original_alias, 0, $maxlength - strlen($unique_suffix)) . $unique_suffix;
	    $i++;
	    } while ($this->_pathauto_alias_exists($alias, $source, $id));
	    
	}
	    return $alias;
	
    }
    function _pathauto_alias_exists($alias, $source, $id){
	
	$model = ClassRegistry::init($source);
	if($id){
	    $page = $model->findById($id);
	    if($page[$source]['url'] != $alias){
		return $model->find('count', array('conditions' => array("$source.url" => $alias)));
	    }else{
		return false;
	    }
	}else{
	    return $model->find('count', array('conditions' => array("$source.url" => $alias)));
	}
    }

}

?>
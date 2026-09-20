<?php if (!defined('FCPATH')) exit('No direct script access allowed.');

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Philip Sturgeon
 */

// ------------------------------------------------------------------------

/**
 * Create URL Title - modified version
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with either a dash
 * or an underscore as the word separator.
 * 
 * Added support for Cyrillic characters.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator: dash, or underscore
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = 'dash', $lowercase = TRUE)
    {
        $CI =& get_instance();
        
        $foreign_characters = array(
            '/ä|æ|ǽ/' => 'ae',
            '/ö|œ/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/À|Á|Â|Ã|Ä|Å|Ǻ|Ā|Ă|Ą|Ǎ|А/' => 'A',
            '/à|á|â|ã|å|ǻ|ā|ă|ą|ǎ|ª|а/' => 'a',
            '/Б/' => 'B',
            '/б/' => 'b',
            '/Ç|Ć|Ĉ|Ċ|Č|Ц/' => 'C',
            '/ç|ć|ĉ|ċ|č|ц/' => 'c',
            '/Ð|Ď|Đ|Д/' => 'D',
            '/ð|ď|đ|д/' => 'd',
            '/È|É|Ê|Ë|Ē|Ĕ|Ė|Ę|Ě|Е|Ё|Э/' => 'E',
            '/è|é|ê|ë|ē|ĕ|ė|ę|ě|е|ё|э/' => 'e',
            '/Ф/' => 'F',
            '/ф/' => 'f',
            '/Ĝ|Ğ|Ġ|Ģ|Г/' => 'G',
            '/ĝ|ğ|ġ|ģ|г/' => 'g',
            '/Ĥ|Ħ|Х/' => 'H',
            '/ĥ|ħ|х/' => 'h',
            '/Ì|Í|Î|Ï|Ĩ|Ī|Ĭ|Ǐ|Į|İ|И/' => 'I',
            '/ì|í|î|ï|ĩ|ī|ĭ|ǐ|į|ı|и/' => 'i',
            '/Ĵ|Й/' => 'J',
            '/ĵ|й/' => 'j',
            '/Ķ|К/' => 'K',
            '/ķ|к/' => 'k',
            '/Ĺ|Ļ|Ľ|Ŀ|Ł|Л/' => 'L',
            '/ĺ|ļ|ľ|ŀ|ł|л/' => 'l',
            '/М/' => 'M',
            '/м/' => 'm',
            '/Ñ|Ń|Ņ|Ň|Н/' => 'N',
            '/ñ|ń|ņ|ň|ŉ|н/' => 'n',
            '/Ò|Ó|Ô|Õ|Ō|Ŏ|Ǒ|Ő|Ơ|Ø|Ǿ|О/' => 'O',
            '/ò|ó|ô|õ|ō|ŏ|ǒ|ő|ơ|ø|ǿ|º|о/' => 'o',
            '/П/' => 'P',
            '/п/' => 'p',
            '/Ŕ|Ŗ|Ř|Р/' => 'R',
            '/ŕ|ŗ|ř|р/' => 'r',
            '/Ś|Ŝ|Ş|Š|С/' => 'S',
            '/ś|ŝ|ş|š|ſ|с/' => 's',
            '/Ţ|Ť|Ŧ|Т/' => 'T',
            '/ţ|ť|ŧ|т/' => 't',
            '/Ù|Ú|Û|Ũ|Ū|Ŭ|Ů|Ű|Ų|Ư|Ǔ|Ǖ|Ǘ|Ǚ|Ǜ|У/' => 'U',
            '/ù|ú|û|ũ|ū|ŭ|ů|ű|ų|ư|ǔ|ǖ|ǘ|ǚ|ǜ|у/' => 'u',
            '/В/' => 'V',
            '/в/' => 'v',
            '/Ý|Ÿ|Ŷ|Ы/' => 'Y',
            '/ý|ÿ|ŷ|ы/' => 'y',
            '/Ŵ/' => 'W',
            '/ŵ/' => 'w',
            '/Ź|Ż|Ž|З/' => 'Z',
            '/ź|ż|ž|з/' => 'z',
            '/Æ|Ǽ/' => 'AE',
            '/ß/'=> 'ss',
            '/Ĳ/' => 'IJ',
            '/ĳ/' => 'ij',
            '/Œ/' => 'OE',
            '/ƒ/' => 'f',
            '/Ч/' => 'Ch',
            '/ч/' => 'ch',
            '/Ю/' => 'Ju',
            '/ю/' => 'ju',
            '/Я/' => 'Ja',
            '/я/' => 'ja',
            '/Ш/' => 'Sh',
            '/ш/' => 'sh',
            '/Щ/' => 'Shch',
            '/щ/' => 'shch',
            '/Ж/' => 'Zh',
            '/ж/' => 'zh',
        );

        $str = preg_replace(array_keys($foreign_characters), array_values($foreign_characters), $str);
        
        $replace = ($separator == 'dash') ? '-' : '_';
        
        $trans = array(
            '&\#\d+?;'                => '',
            '&\S+?;'                => '',
            '\s+'                    => $replace,
            '[^a-z0-9\-\._]' => '',
            $replace.'+'            => $replace,
            $replace.'$'            => $replace,
            '^'.$replace            => $replace,
            '\.+$'                    => ''
        );

        $str = strip_tags($str);

        foreach ($trans as $key => $val)
        {
            $str = preg_replace("#".$key."#i", $val, $str);
        }
        
        if ($lowercase === TRUE)
        {
            if( function_exists('mb_convert_case') )
            {
                $str = mb_convert_case($str, MB_CASE_LOWER, "UTF-8");
            }
            else
            {
                $str = strtolower($str);
            }
        }

        $str = preg_replace('#[^'.$CI->config->item('permitted_uri_chars').']#i', '', $str);        
        return trim(stripslashes(strtolower($str)));
     }
}


 
// ------------------------------------------------------------------------


/**
 * Theme URL
 *
 * Returns the Ionize current theme URL
 *
 * @access	public
 * @return	string
 */
 

if ( ! function_exists('assets_url'))
{
	function assets_url($arg)
	{
		return base_url()."public/assets/".$arg;
	}
}

if ( ! function_exists('assets_image_url'))
{
	function assets_image_url($arg)
	{
		return base_url()."public/assets/".$arg;
	}
}

if ( ! function_exists('uploaded_image_url'))
{
	function uploaded_image_url($img)
	{
		return base_url()."public/uploads/".$img;
	}
}

if ( ! function_exists('uploaded_folder_url'))
{
	function uploaded_folder_url($path = '')
	{
		return base_url('public/uploaded_folder/' . ltrim((string) $path, '/'));
	}
}

if ( ! function_exists('setting'))
{
	function setting(string $key, $default = '')
	{
		static $settings = null;
		if ($settings === null) {
			try {
				$db = \Config\Database::connect();
				if ($db->tableExists('site_settings')) {
					$rows = $db->table('site_settings')->get()->getResult();
					$settings = [];
					foreach ($rows as $row) {
						$settings[$row->setting_key] = $row->setting_value;
					}
				} else {
					$settings = [];
				}
			} catch (\Throwable $e) {
				$settings = [];
			}
		}
		return $settings[$key] ?? $default;
	}
}

if ( ! function_exists('thumb_cache_url'))
{
	function thumb_cache_url()
	{
		return base_url()."writable/cache/";
	}
	
}

if ( ! function_exists('getDateFormat')){	

	function getDateFormat($date,$format,$seperator1=",")
	{
		switch($format)
		{
			case 1: // (Ymd)->(dmY) 06 Dec, 2010 
				$arr_date=explode($seperator1,$date);			 
				$arr_date=strtotime($arr_date[0]);
				return $ret_date=date("d M".$seperator1." Y",$arr_date);           
			break;
		
			case 2: // (Ymd)->(dmY) 06 December, 2010
				$arr_date=explode($seperator1,$date);			 
				$arr_date=strtotime($arr_date[0]);
				return $ret_date=date("d F".$seperator1." Y",$arr_date);           
			break;
			
			case 3: // (Ymd)->(dmY) Mon Dec 06, 2010 
				$arr_date=explode($seperator1,$date);			 
				$arr_date=strtotime($arr_date[0]);
				return $ret_date=date("D M d".$seperator1." Y",$arr_date);           
			break;
			
			case 4: // (Ymd)->(dmY) Monday December 06, 2010 
				$arr_date=explode($seperator1,$date);			 
				$arr_date=strtotime($arr_date[0]);
				return $ret_date=date("l F d".$seperator1." Y",$arr_date);           
			break;
			
			case 5: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 
				
				$arr_time1=explode(" ",$date);			 
				$arr_date=strtotime($date);
				return $ret_date=date("l F d".$seperator1." Y".$seperator1." h:i:s",$arr_date);
				break;
			
			case 6: // (Ymd)->(dmY) 06 Dec, 2010, 15:03:PM 
				$arr_time1=explode(" ",$date);			 
				$arr_date=strtotime($date);
				return $ret_date=date("d M".$seperator1." Y".$seperator1." H:i:A",$arr_date);           
			break;
			
			case 7: // (Ymd)->(dmY) Monday December 06, 2010, 15:03:PM 
				$arr_time1=explode(" ",$date);			 
				$arr_date=strtotime($date);
				return $ret_date=date("d M".$seperator1." Y".$seperator1." H:i:A",$arr_date);           
			break;
			
			case 8: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 
				$arr_time1=explode(" ",$date);			 
				$arr_date=strtotime($date);
				return $ret_date=date("d M".$seperator1." Y".$seperator1." h:i",$arr_date);           
			break;
			case 9: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 
				$arr_time1=explode(" ",$date);			 
				$arr_date=strtotime($date);
				return $ret_date=date("d".$seperator1."m".$seperator1."Y h:i",$arr_date);           
			break;
			
			case 10: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 
				$arr_time1=explode(" ",$date);			 
				$arr_date=strtotime($date);
				return $ret_date=date("d".$seperator1."m".$seperator1."Y",$arr_date);           
			break;
			
			case 11: // (Ymd)->(dmY) Monday December 06, 2010, 03:04:00 
				$arr_time1=explode(" ",$date);			 
				$arr_date=strtotime($date);
				return $ret_date=date("d".$seperator1."m".$seperator1."Y h:i:sA",$arr_date);           
			break;

			
		}
		return date("d/m/Y",strtotime($date));
		//return $ret_date;
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Output Cache Helper
 *
 * Utility functions for working with CodeIgniter's output cache.
 * All code based on or directly copied from CodeIgniter.
 *
 * @category	Helpers
 * @author		Steven Benner
 * @link		http://stevenbenner.com/2010/12/caching-with-codeigniter-zen-headaches-and-perfomance/
 * @version		1.3
 */

// NOTE: This code is for CodeIgniter 2.0. For CI < 1.7.x replace APPPATH with BASEPATH

/**
 * Get Cache File
 *
 * Gets the path to a cache file for the specified uri_string().
 *
 * @author	Steven Benner
 * @param	string	Full uri_string() of the target page (e.g. '/blog/comments/123')
 * @return	string	Path to the cache file.
 */
if ( ! function_exists('get_cache_file'))
{
	function get_cache_file($uri_string)
	{
		$CI =& get_instance();

		$path = $CI->config->item('cache_path');

		$cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

		$uri =  $CI->config->item('base_url') .
				$CI->config->item('index_page') .
				$uri_string;

		return $cache_path . md5($uri);
	}
}

/**
 * Get All Cache Files
 *
 * Gets the path to every cache file currently saved.
 *
 * @author	Steven Benner
 * @return	array	Array of cache file paths.
 */
if ( ! function_exists('get_all_cache_files'))
{
	function get_all_cache_files()
	{
		$CI =& get_instance();

		$CI->load->helper('file');

		$path = $CI->config->item('cache_path');

		$cache_path = ($path == '') ? APPPATH . 'cache/' : $path;

		return get_filenames($cache_path);
	}
}


/**
 * Delete Cache File
 *
 * Evicts the output cache for the targeted page.
 *
 * @author	Steven Benner
 * @param	string	Full uri_string() of the target page (e.g. '/blog/comments/123')
 * @return	boolean	TRUE if the cache file was removed, FALSE if it was not
 */
if ( ! function_exists('delete_cache'))
{
	function delete_cache($uri_string)
	{
		$cache_path = get_cache_file($uri_string);

		if (file_exists($cache_path))
		{
			return unlink($cache_path);
		}
		else
		{
			return TRUE;
		}
	}
}

/**
 * Delete All Cache
 *
 * Evicts the output cache for all pages currently cached.
 *
 * @author	Steven Benner
 * @return	void
 */
if ( ! function_exists('delete_all_cache'))
{
	function delete_all_cache()
	{
		$cache_files = get_all_cache_files();

		foreach ($cache_files as $file)
		{
			// only delete files with names that are 32
			// characters in length (MD5)
			if (strlen($file) === 32)
			{
				@unlink($cache_path . $file);
			}
		}
	}
}

/**
 * Get Cache Expiration
 *
 * Gets the expiration time for a cache file. Time strings are in time() format.
 *
 * @author	Steven Benner
 * @param	string	$uri_string	Full uri_string() of the target page
 * @return	mixed	Time from the cache file or FALSE if there was a problem
 */
if ( ! function_exists('get_cache_expiration'))
{
	function get_cache_expiration($uri_string)
	{
		$cache_path = get_cache_file($uri_string);

		if ( ! @file_exists($cache_path))
		{
			return FALSE;
		}

		if ( ! $fp = @fopen($cache_path, FOPEN_READ))
		{
			return FALSE;
		}

		flock($fp, LOCK_SH);

		$time_str = '';
		while (($char = fgetc($fp)) !== FALSE)
		{
			if ($char === 'T')
			{
				break;
			}
			$time_str .= $char;
		}

		flock($fp, LOCK_UN);
		fclose($fp);

		if (ctype_digit($time_str))
		{
			return (int)$time_str;
		}
		else
		{
			return FALSE;
		}
	}
}

/* End of file cache_helper.php */
/* Location: ./application/helpers/cache_helper.php */
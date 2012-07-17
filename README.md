# CodeIgniter Cache Helper

I am a huge fan of output caching and CodeIgniter has a very effective output caching system, however, it is lacking some very important functions for managing the cache files. CodeIgniter Cache Helper fixes that issue by giving you a simple helper that you can add to your CodeIgniter project that will let you manage your output cache files in code.

## Requirements

* CodeIgniter 2.0+ (It can be modified to work in <1.7.2 by changing "APPPATH" to "BASEPATH")

## Installation

### Manual installation

Add the cache_helper.php file to your "helpers" directory in the application folder.

### Spark installation

This helper can be installed and run as a [spark](http://getsparks.org/). Install the current version with this command:

`php tools\spark install -v1.4.1 cache-helper`

## Usage

Load the helper any time you want to use its functions. You can then call any of the functions directly. Helper functions do not need to be called through CodeIgniter's `$this` object.

### For manual install

```php
$this->load->helper('cache');
```

### For spark install

```php
$this->load->spark('cache-helper/1.4.1');
```

## Function reference

### get_cache_folder()

Returns a string containing the path to the cache directory.

#### Example return

`'/var/www/application/cache'`

### get_cache_file($uri_string)

Returns a string with the path to the cache file for a specific URI.

#### Notes

* Call this function with the URI string of the resource you are looking for (e.g. 'blog/article/123'). This is designed to be used with CodeIgniter's `uri_string()` method from the [URI Class](http://codeigniter.com/user_guide/libraries/uri.html).

* This function does not check for the existence of that cache file, it merely tells you where CodeIgniter would cache the file.

#### Example return

`'/var/www/application/cache/d41d8cd98f00b204e9800998ecf8427e'`

### get_all_cache_files()

Returns an object containing information for every file in the cache directory.

#### Notes

* Uses the `get_dir_file_info()` function from the [File Helper](http://codeigniter.com/user_guide/helpers/file_helper.html). The returned object will be in that format.

### delete_cache($uri_string)

Attempts to delete the cached file for the specified resource. Returns `TRUE` upon success or if that file does not exist, returns `FALSE` on failure.

#### Notes

* Call this function with the URI string of the resource you are looking for (e.g. 'blog/article/123'). This is designed to be used with CodeIgniter's `uri_string()` method from the [URI Class](http://codeigniter.com/user_guide/libraries/uri.html).

### delete_all_cache()

Attempts to delete ALL cache files. Does not return anything.

### delete_expired_cache()

Attempts to delete all cache files which have expired. Does not return anything.

#### Notes

* This function will iterate through every file in the cache directory and try to read the expiration time from the file. If you have a large cache directory and/or slow I/O then this can be a slow operation.

### get_cache_expiration($uri_string)

Attempts to read the expiration time stamp from the cache file for the specified resource. Returns an integer with the time stamp (UNIX time stamp in `time()` format) if it could find and parse the file, returns `FALSE` if there is no cache file for the resource or if there was a problem reading/parsing the file.

#### Notes

* Call this function with the URI string of the resource you are looking for (e.g. 'blog/article/123'). This is designed to be used with CodeIgniter's `uri_string()` method from the [URI Class](http://codeigniter.com/user_guide/libraries/uri.html).

## License

*(This project is released under the MIT license.)*

Copyright (c) 2012 Steven Benner, http://stevenbenner.com/

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

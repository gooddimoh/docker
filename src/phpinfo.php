<?php 
//die();
//ini_set('max_execution_time', 100);
//echo ini_get('max_execution_time');
//echo get_cfg_var('cfg_file_path');
//phpinfo();

die();

$s = "session.auto_start,
session.bug_compat_42,
session.bug_compat_warn,
session.cache_expire,
session.cache_limiter,
session.cookie_domain,
session.cookie_httponly,
session.cookie_lifetime,
session.cookie_path,
session.cookie_secure,
session.entropy_file,
session.entropy_length,
session.gc_divisor,
session.gc_maxlifetime,
session.gc_probability,
session.hash_bits_per_character,
session.hash_function,
session.name,
session.referer_check,
session.save_handler,
session.save_path,
session.serialize_handler,
session.use_cookies,
session.use_only_cookies,
session.use_trans_sid,
session.gc_maxlifetime,
session.cookie_lifetime";

foreach(explode(',', $s) as $el)
{
    $el = trim($el);
    echo $el .': ' . ini_get($el) . "<br />\r\n";
}


?>
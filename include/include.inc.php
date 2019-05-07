<?php
/*********************************************************************************************
DATE      : 
AUTHOR    : 
COPYRIGHT : 
*********************************************************************************************/

/*****************************************************************************************
/* INCLUDE
*****************************************************************************************/
if(count($ini_array['include']) > 0)
{
    foreach($ini_array['include'] as $value)
    {
        $dest_dir = dirname(__FILE__)."/".$value;
        if(is_dir($dest_dir))
        {
            if($dh = opendir($dest_dir))
            {
                while($file = readdir($dh))
                {
                    $dest_file  = $dest_dir."/".$file;
                    $path_parts = pathinfo($dest_file);
                    $file_ext   = $path_parts['extension'];
                    if('php' == $file_ext || 'PHP' == $file_ext)
                    {
                        include_once($dest_file);
                    }
                }
                closedir($dh);
            }
        }
        else 
        {
            print($dest_dir.' is not a directory!!');
        }
    }
}

/*****************************************************************************************
/* REQUIRE
*****************************************************************************************/
if(count($ini_array['require']) > 0)
{
    foreach($ini_array['require'] as $value)
    {
        require_files(dirname(__FILE__)."/".$value);
    }
}

function require_files($dest_dir = '')
{
    if(is_dir($dest_dir))
    {
        if($dh = opendir($dest_dir))
        {
            while($file = readdir($dh))
            {
                $dest_file  = $dest_dir."/".$file;
                $path_parts = pathinfo($dest_file);
                $file_ext   = $path_parts['extension'];
                if('php' == $file_ext || 'PHP' == $file_ext)
                {
                    require_once($dest_file);
                }
            }
            closedir($dh);
        }
    }
    else 
    {
        print($dest_dir.' is not a directory!!');
    }
}
?>
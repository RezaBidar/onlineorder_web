<?php 

use \Auth;
use \Request;
use \URL;

if (! function_exists('showMenu')) {
    /**
     * make menu from array
     *
     * @return text
     */
    function showMenu()
    {
        $menu = config('app.menu') ;
        $menu = $menu[Auth::user()->type];

        $text = '' ;
        /**
        <li class="active">
        <a href="index.html">
        <i class="icon-dashboard"></i>
        <span>Dashboard</span> 
        </a> 
        </li>

        <li>
        <a href="reports.html">
        <i class="icon-list-alt"></i>
        <span>Reports</span> 
        </a> 
        </li>

        <li class="dropdown">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> 
        <i class="icon-long-arrow-down"></i>
        <span>Drops</span> 
        <b class="caret"></b>
        </a>
          <ul class="dropdown-menu">
            <li><a href="icons.html">Icons</a></li>
            <li><a href="faq.html">FAQ</a></li>
          </ul>
        </li>
        */

        foreach ($menu as $name => $item)
        {
            $active = false ;
            
            if(isset($item['dropdown']))
            {
                $text .= '<li class="dropdown menu-'. $name .'">' . PHP_EOL ;
                $text .= '<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"> '. PHP_EOL;
            }
            else 
            {
                $text .= '<li class="menu-'. $name .'">' . PHP_EOL ;
                $text .= '<a href="'.(isset($item['action']) ? route($item['action']) : '' ).'">' . PHP_EOL;
            }

            $text .= '<i class="'. $item['icon'] .'"></i>'. PHP_EOL;
            $text .= '<span>'. $item['title'] .'</span>'. PHP_EOL;
            
            if(isset($item['dropdown']))
            {
                $text .= '<b class="caret"></b>';
                $text .= '</a>'. PHP_EOL;
                $text .= '<ul class="dropdown-menu">' ;
                foreach ($item['dropdown'] as $subName => $subItem) 
                {
                    $text .= '<li>' . PHP_EOL ;
                    $text .= '<a href="'.(isset($subItem['action']) ? route($subItem['action']) : '' ).'">' . PHP_EOL;
                    $text .= '<span>'. $subItem['title'] .'</span>'. PHP_EOL;
                    $text .= '</a>'. PHP_EOL;       
                    $text .= '</li>'. PHP_EOL;

                    $active = (!$active && isset($subItem['action'])) 
                                ? $subItem['action'] == Request::route()->getName() : $active ;        
                }
                $text .= '</ul>' ;
            }
            else 
            {
                $text .= '</a>'. PHP_EOL;
                $active = (!$active && isset($item['action'])) 
                                ? $item['action'] == Request::route()->getName() : $active ;
            }

            $text .= '</li>'. PHP_EOL;

            if($active)
            {
                $text = str_replace('menu-'. $name , 'active', $text);
            }
        }

        return $text ;
    }
}



if (! function_exists('getAvatar')) 
{

    function getAvatar($pic)
    {
        
        if(is_file('pic/avatars/' . $pic ))
            return '<img src="'. URL::asset('pic/avatars/' . $pic ) .'" class="img-responsive img-circle" style="width: 50px;" />';

        return '<img src="'. URL::asset('pic/avatars/blank.jpg') .'" class="img-responsive img-circle" style="width: 50px;" />';
    }
}

if (! function_exists('getOriginalAvatar')) 
{

    function getOriginalAvatar($pic)
    {
        
        if(is_file('pic/avatars/' . $pic ))
            return '<img src="'. URL::asset('pic/avatars/' . $pic ) .'" class="img-responsive img-circle" />';

        return '<img src="'. URL::asset('pic/avatars/blank.jpg') .'" class="img-responsive img-circle" />';
    }
}

if (! function_exists('getProductThumb')) 
{

    function getProductThumb($pic)
    {
        if(is_file('pic/products/thumbs/' . $pic ))
            return '<img src="'. URL::asset('pic/products/thumbs/' . $pic ) .'" class="img-responsive img-circle" />';

        return '<img src="'. URL::asset('pic/products/thumbs/blank.png') .'" class="img-responsive img-circle" />';
    }

}

if (! function_exists('getProductPic')) 
{

    function getProductPic($pic)
    {
        if(is_file('pic/products/' . $pic ))
            return '<img src="'. URL::asset('pic/products/' . $pic ) .'" class="img-responsive img-rounded" />';

        return '<img src="'. URL::asset('pic/products/blank.png') .'" class="img-responsive img-rounded" />';
    }

}

if (! function_exists('getCurrentUserCompany'))
{
    /**
     * if user did not register in any company then this function return null 
     */
    function getCurrentUserCompany()
    {
        $companies = Auth::user()->companies;
        return (sizeof($companies) > 0 ) ? $companies[0] : null ;
    }
}
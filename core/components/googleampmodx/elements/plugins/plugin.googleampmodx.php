<?php
/*
 * Автор плагина: Сергей Зверев <element1493@yandex.ru>
 * Библиотека: AMP PHP Library [https://github.com/Lullabot/amp-library]
 * Версия библиотеки: 2.0.1
 */
require_once(MODX_CORE_PATH.'components/googleampmodx/vendor/autoload.php' );

use Lullabot\AMP\AMP;
use Lullabot\AMP\Validate\Scope;

$eventName = $modx->event->name;
if($eventName == 'OnLoadWebDocument') {
    $id = $modx->resource->get('id');
    $name_get = ($modx->getOption('googleAmpModx_get'))?:'amp';
    $content = $modx->resource->get('content');
    if(!empty($content)){
        if($modx->cacheManager->get('googleAmpModx_'.$name_get.'_'.$id) && $modx->getOption('googleAmpModx_cache')){  
            $content = $modx->cacheManager->get('googleAmpModx_'.$name_get.'_'.$id);
        }else{
            if(!function_exists('parser')){
                function parser($value){
                    global $modx;
                    $maxIterations = (integer)$modx->getOption('parser_max_iterations', null, 10);
                    $modx->getParser()->processElementTags('', $value, false, false, '[[', ']]', array(), $maxIterations);
                    $modx->getParser()->processElementTags('', $value, true, true, '[[', ']]', array(), $maxIterations);
                    return $value;
                }
            }
            if(!function_exists('url_src')){
                function url_src($matches){
                    global $modx;
                    $src = $matches[0];
                    if(strpos($matches[1], ':tag]]') === false){
                        $matches[1] = parser($matches[1]);
                    }
                    if(filter_var($matches[1], FILTER_VALIDATE_URL)!== false){
                        $src = 'src="'.$matches[1];
                    }else{
                        if(!strpos($matches[1], $modx->getOption('http_host'))){
                            if($matches[1][0] == '/'){
                                $src = 'src="'.$modx->getOption('site_url').substr($matches[1], 1);
                            }else{
                                $src = 'src="'.$modx->getOption('site_url').$matches[1];
                            }
                        }else{
                            $src = 'src="'.$matches[1];
                        }
                    }
                    return $src;
                }
            }
            if(!function_exists('url_href')){
                function url_href($matches){
                    global $modx;
                    $href = $matches[0];
                    if(strpos($matches[1], ':tag]]') === false){
                        $matches[1] = parser($matches[1]);
                    }
                    if(filter_var($matches[1], FILTER_VALIDATE_URL)){
                        $href = 'href="'.$matches[1];
                    }else{
                        if(!strpos($matches[1], $modx->getOption('http_host'))){
                            if($matches[1][0] == '/'){
                                $href = 'href="'.$modx->getOption('site_url').substr($matches[1], 1);
                            }else{
                                $href = 'href="'.$modx->getOption('site_url').$matches[1];
                            }
                        }else{
                            $href = 'href="'.$matches[1];
                        }
                    }
                    return $href;
                }
            }
            
            $content = preg_replace_callback('~src="([^"]*)|<pre(.*?)</pre>(*SKIP)(*F)~isu', 'url_src', $content);
            $content = preg_replace_callback('~href="([^"]*)|<pre(.*?)</pre>(*SKIP)(*F)~isu', 'url_href', $content);
            
            $amp = new AMP();
            $amp->loadHtml($content);
            $content = $amp->convertToAmpHtml();
            
            if($modx->getOption('googleAmpModx_warnings')) $modx->log(1, htmlentities($amp->warningsHumanText()));
            if($modx->getOption('googleAmpModx_cache')) $modx->cacheManager->set('googleAmpModx_'.$name_get.'_'.$id, $content, 86400);
        }
    }
    if (isset($_GET[$name_get])){
        $template = ($_GET[$name_get]!='')? $_GET[$name_get]:$modx->getOption('googleAmpModx_template');
            
        $modx->resource->set('cacheable', 0);
        $modx->resource->set('template', $template);
        $modx->resource->set('content', '<div>'.$content.'</div>');
        
    }
    return;
}
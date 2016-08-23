<?php
/*
 * Script for creating articles in Joomla with external php file placed in the root directory of Joomla package
*/

if (!defined('_JEXEC')) {
    define( '_JEXEC', 1 );
    define('JPATH_BASE', realpath(dirname(__FILE__)));
    require_once ( JPATH_BASE .'/includes/defines.php' );
    require_once ( JPATH_BASE .'/includes/framework.php' );
    defined('DS') or define('DS', DIRECTORY_SEPARATOR);
}


$app = JFactory::getApplication('site');

$article_data = array(
    'id' => 0,
    'catid' => 3,
    'title' => 'Hello World',
    'alias' => 'my-article-alias',
    'introtext' => 'My intro text',
    'fulltext' => 'My full text',
    'state' => 1, //if you want to keep the article published else 0
    'alias' => 'my-article-path',
    'state'=>1,
    'language' => '*',
    'access' => 1,
    'metadata' => json_encode(array('author' => '', 'robots' => ''))
);

$article_id = createArticle($article_data);
if(!$article_id){
    echo "Article create failed!";
}else{
	echo "Article Create with id : ". $article_id;
}


function createArticle($data)
{
    $data['rules'] = array(
        'core.edit.delete' => array(),
        'core.edit.edit' => array(),
        'core.edit.state' => array(),
    );

    //print_r($data);
    $basePath = JPATH_ADMINISTRATOR.'/components/com_content';
    require_once $basePath.'/models/article.php';
    $config = array();
    $article_model =  JModelLegacy::getInstance('Article','ContentModel');//new ContentModelArticle($config);////
    if(!$article_model->save($data)){
        $err_msg = $article_model->getError();
        return false;
    }else{
        $id = $article_model->getItem()->id;
        return $id;
    }

}

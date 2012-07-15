<?php 

/**
 * jquery.beautyOfCode Pluing을 이용한 SyntaxHighlighter Helper 입니다.
 * (http://startbigthinksmall.wordpress.com/2008/10/30/beautyofcode-jquery-plugin-for-syntax-highlighting/) 
 *
 * @file          app/views/helpers/syntax_hihglighter.php 
 * @copyright     Copyright 2011, xEspresso (http://xespresso.net)
 * @link          http://xespresso.net
 * @package       cakephp.views.helpers
 * @subpackage    cakephp.views.helpers.syntax_highlighter
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author				Kim Jeong soo
 */
 
class SyntaxHighlighterHelper extends Helper
{
    function load($javascript){


			echo $javascript->link(array('/board/js/jquery.beautyOfCode-min'),false);
			//brushes : http://alexgorbatchev.com/SyntaxHighlighter/manual/brushes/
			echo $javascript->codeBlock("

				$.beautyOfCode.init({
					baseUrl: 'http://alexgorbatchev.com/pub/sh/2.0.320/',
					brushes: ['Xml', 'JScript', 'CSharp', 'Plain', 'Php', 'Java', 'Sql']
				});

				",array('inline'=>false)
			);

    }
    
    
    function convert($data)
    {

		  preg_match_all("/\[code ([a-z]+)\](.*?)\[\/code\]/s", $data, $matches,PREG_SET_ORDER);
		  
		  foreach($matches as $row)
		  {
		  	$data = str_replace($row[2], preg_replace(array('/<br[^>]*?>/','/\[/s','/\]/s'),array('','&#91;','&#93;'),$row[2]), $data);
		  }

			
			$patterns = array(
				'/\[code ([a-z]+)\]/',
				'/\[\/code\]/'
				
			);
			$replaces = array(
				"<pre class=\"code\"><code class=\"$1\">",
				"</code></pre>"
			);
			return preg_replace($patterns, $replaces, $data);

    }
}
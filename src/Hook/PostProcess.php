<?php
/* @description     Transformation Style Sheets - Revolutionising PHP templating    *
 * @author          Tom Butler tom@r.je                                             *
 * @copyright       2015 Tom Butler <tom@r.je> | https://r.je/                      *
 * @license         http://www.opensource.org/licenses/bsd-license.php  BSD License *
 * @version         0.9                                                             */
namespace Transphporm\Hook;
/** Hooks into the template system, gets assigned as `ul li` or similar and `run()` is called with any elements that match */
class PostProcess implements \Transphporm\Hook {
	public function run(\DomElement $element) {
		$transphporm = $element->getAttribute('transphporm');
		var_dump($transphporm);
		if ($transphporm == 'remove') $element->parentNode->removeChild($element);
		else $element->removeAttribute('transphporm');
	}

}
<?php
/* @description     Transformation Style Sheets - Revolutionising PHP templating    *
 * @author          Tom Butler tom@r.je                                             *
 * @copyright       2015 Tom Butler <tom@r.je> | https://r.je/                      *
 * @license         http://www.opensource.org/licenses/bsd-license.php  BSD License *
 * @version         0.9                                                             */
use Transphporm\Builder;
class CacheTest extends PHPUnit_Framework_TestCase {

	private function makeTss($tss) {
		file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'temp.tss', $tss);
		return __DIR__ . DIRECTORY_SEPARATOR . 'temp.tss';
	}

	private function makeXml($xml) {
		file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . 'temp.xml', $xml);
		return __DIR__ . DIRECTORY_SEPARATOR . 'temp.xml';	
	}

	public function testCacheBasic() {

		$xml = $this->makeXML('
				<div>test</div>
		');

		$css = $this->makeTss('div {content: data(getRand); update-frequency: never;}');


		$random = new RandomGenerator;
		$cache = new \ArrayObject;

		$template = new Builder($xml, $css);
		$template->setCache($cache);

		$o1 = $template->output($random)->body;
		
		$template = new Builder($xml, $css);
		$template->setCache($cache);

		$o2 = $template->output($random)->body;

		// If the cache is working, the content should not be updated the second time
		$this->assertEquals($o1, $o2);

		//And the getRand function on the random class should only be called once
		$this->assertEquals(1, $random->getCount());

	}


}

class RandomGenerator {
	private $count = 0;

	public function getRand() {
		$this->count++;
		return rand();
	}

	public function getCount() {
		return $this->count;
	}
}
<?php

namespace Slendium\CompositorTests\Html;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Compositor\Component;
use Slendium\Compositor\Html\Formattable;

use Slendium\CompositorTests\Html\Fixtures\CompositorFixtures;
use Slendium\CompositorTests\Html\Components\DivWrapper;
use Slendium\CompositorTests\Html\Components\FormattableComponent;
use Slendium\CompositorTests\Html\Components\TextComponent;

class HtmlTwoPhaseCompositionTest extends TestCase {

	public static function composeCases(): iterable {
		yield [ new TextComponent('no escapes'), 'no escapes' ];
		yield [ new TextComponent('should <b>be</b> escaped'), 'should &lt;b&gt;be&lt;/b&gt; escaped' ];
		yield [ new DivWrapper(new TextComponent('wrapped')), '<div>wrapped</div>' ];
	}

	#[DataProvider('composeCases')]
	public function test_compose_shouldConvertTreeIntoValidHtml(Component $tree, string $expectedHtml) {
		$sut = CompositorFixtures::twoPhaseEnglishNoReplace();

		$result = \implode('', \iterator_to_array($sut->compose($tree), preserve_keys: false));

		$this->assertSame($expectedHtml, $result);
	}

	public static function composeWithComponentClassCases(): iterable {
		yield [ new TextComponent(''), [ TextComponent::class ] ];
		yield [ new DivWrapper(new TextComponent('')), [ TextComponent::class, DivWrapper::class ] ];
		yield [ new DivWrapper(new DivWrapper(new TextComponent(''))), [ TextComponent::class, DivWrapper::class ] ];
	}

	#[DataProvider('composeWithComponentClassCases')]
	public function test_compose_shouldAggregateComponentClasses(Component $tree, array $expectedClasses) {
		$sut = CompositorFixtures::twoPhaseEnglishNoReplace();

		$result = $sut->compose($tree)->componentClasses;

		$this->assertEqualsCanonicalizing($expectedClasses, $result);
	}

	public function test_compose_shouldNotTriggerFormattableCallback() {
		$formattable = new class implements Formattable {
			public bool $called = false;
			#[Override]
			public function generateHtml(): iterable {
				$this->called = true;
				yield '';
			}
		};
		$sut = CompositorFixtures::twoPhaseEnglishNoReplace();

		$composition = $sut->compose(new FormattableComponent($formattable));
		$this->assertFalse($formattable->called);
		\iterator_to_array($composition);
		$this->assertTrue($formattable->called);
	}

}

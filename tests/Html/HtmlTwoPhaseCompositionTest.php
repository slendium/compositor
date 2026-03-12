<?php

namespace Slendium\CompositorTests\Html;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Slendium\Compositor\Html\Component as HtmlComponent;
use Slendium\Compositor\Html\Formattable;
use Slendium\Compositor\Base\Html\EscapedTextCallback;
use Slendium\Compositor\Base\Html\UnescapedCharacterData;

use Slendium\CompositorTests\Html\Fixtures\CompositorFixtures;
use Slendium\CompositorTests\Html\Components\DivWrapper;
use Slendium\CompositorTests\Html\Components\FormattableComponent;
use Slendium\CompositorTests\Html\Components\Library;
use Slendium\CompositorTests\Html\Components\TextComponent;

/**
 * @internal
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class HtmlTwoPhaseCompositionTest extends TestCase {

	public static function composeCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ new TextComponent('no escapes'), 'no escapes' ];
		yield [ new TextComponent('should <b>be</b> escaped'), 'should &lt;b&gt;be&lt;/b&gt; escaped' ];
		yield [ new DivWrapper(new TextComponent('wrapped')), '<div>wrapped</div>' ];
		yield [ new FormattableComponent(new UnescapedCharacterData('<script>alert();</script>')), '<script>alert();</script>' ];
	}

	#[DataProvider('composeCases')]
	public function test_compose_shouldConvertTreeIntoValidHtml(HtmlComponent $tree, string $expectedHtml): void {
		$sut = CompositorFixtures::twoPhaseEnglishNoReplace();

		$result = \implode('', \iterator_to_array($sut->compose($tree), preserve_keys: false));

		$this->assertSame($expectedHtml, $result);
	}

	public static function composeWithComponentClassCases(): iterable { // @phpstan-ignore missingType.iterableValue
		yield [ new TextComponent(''), [ TextComponent::class ] ];
		yield [ new DivWrapper(new TextComponent('')), [ TextComponent::class, DivWrapper::class ] ];
		yield [ new DivWrapper(new DivWrapper(new TextComponent(''))), [ TextComponent::class, DivWrapper::class ] ];
	}

	/** @param list<class-string> $expectedClasses */
	#[DataProvider('composeWithComponentClassCases')]
	public function test_compose_shouldAggregateComponentClasses(HtmlComponent $tree, array $expectedClasses): void {
		$sut = CompositorFixtures::twoPhaseEnglishNoReplace();

		$result = $sut->compose($tree)->componentClasses;

		$this->assertEqualsCanonicalizing($expectedClasses, $result);
	}

	public function test_compose_shouldNotTriggerFormattableCallback(): void {
		// Arrange
		$called = false;
		$component = new FormattableComponent(new EscapedTextCallback(function () use (&$called) {
			$called = true;
			return '';
		}));
		$sut = CompositorFixtures::twoPhaseEnglishNoReplace();

		// Act
		$composition = $sut->compose($component);
		// Assert
		$this->assertFalse($called);
		// Act
		\iterator_to_array($composition);
		// Assert
		$this->assertTrue($called); // @phpstan-ignore method.impossibleType
	}

	public function test_compose_shouldIncludeLibraries(): void {
		$tree = new TextComponent('');
		$sut = CompositorFixtures::twoPhaseEnglishNoReplace();

		$result = \iterator_to_array($sut->compose($tree)->generateLibraries(), preserve_keys: false);

		$this->assertSame(1, \count($result));
		$this->assertInstanceOf(Library::class, $result[0]);
	}

}

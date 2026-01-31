<?php

namespace Slendium\Compositor;

/**
 * Combined metadata for component libraries.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
abstract class ComponentLibrary {

	/** @since 1.0 */
	public final function __construct() { }

	/**
	 * Returns the directories to extract component resources from (JS/CSS).
	 * @since 1.0
	 * @return iterable<string> The directories to extract resources from (such as `__DIR__`),
	 *  in order of inclusion
	 */
	public abstract function getResourceDirectories(): iterable;

}

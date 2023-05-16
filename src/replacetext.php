<?php
/**
 * Console application, which replace text argument
 *
 * @package wordpress
 */
error_reporting( E_ALL );

use Composer\Factory;

/**
 * Class ReplaceText
 *
 * @author Louis Vedel <contact@louisvedel.fr>
 * @since 1.0
 */
class ReplaceText {
	/**
	 * @var string
	 * @access
	 */
	var $modified_contents = '';

	/**
	 * Constructor.
	 */
	public function __construct() {

	}

	/**
	 * Prints CLI usage.
	 */
	public function usage() {
		$usage = "Usage: php replacetext.php [-i] <text-to-search> <text-to-replace> <file>\n\nReplace the string <text-to-search> by <text-replacement> in <file>\nand prints the modified php file on standard output.\n\nOptions:\n    -i    Modifies the PHP file in place, instead of printing it to standard output.\n";
		fwrite( STDERR, $usage );
		exit( 1 );
	}

	/**
	 * replace text to a single file.
	 *
	 * @param string $dirname The directory to filter.
	 * @param array<string> $exclude The file paths to exclude.
	 *
	 */
	public function filter_dir( $dirname, $exclude ) {
		$dirs     = new RecursiveDirectoryIterator( $dirname, RecursiveDirectoryIterator::SKIP_DOTS | RecursiveDirectoryIterator::UNIX_PATHS );
		$callback = new RecursiveCallbackFilterIterator( $dirs, function ( $file, $key, $iterator ) use ( $exclude ) {
			return ($file->isFile() || $iterator->hasChildren()) && ! in_array( $file->getFilename(), $exclude );
		} );
		return $callback;
	}

	/**
	 * replace text recursively.
	 *
	 * @param string $search The value being searched for, otherwise known as the needle.
	 * @param string $replace The replacement value that replaces found search value.
	 * @param string $source_dirname Filename with optional path.
	 * @param bool   $inplace True to modifies the PHP file in place. False to print to standard output.
	 *
	 */
	public function process_folder( $search, $replace, $source_dirname, $exclude, $inplace ) {
		$callback = $this->filter_dir( $source_dirname, $exclude );
		$files    = new RecursiveIteratorIterator( $callback, RecursiveIteratorIterator::CHILD_FIRST );
		foreach ( $files as $file ) {
			if( $file->isFile() ) {
				$this->process_file( $search, $replace, $file->getPathname(), $inplace );
			} else {
				$this->process_folder($search, $replace, $file->getPathname(), $exclude, $inplace );
			}
		}
	}

	/**
	 * replace text to a single file.
	 *
	 * @param string $search The value being searched for, otherwise known as the needle.
	 * @param string $replace The replacement value that replaces found search value.
	 * @param string $source_filename Filename with optional path.
	 * @param bool   $inplace True to modifies the PHP file in place. False to print to standard output.
	 *
	 */
	public function process_file( $search, $replace, $source_filename, $inplace ) {
		$new_source = str_replace( $search, $replace, file_get_contents( $source_filename ) );

		if ( $inplace ) {
			$f = fopen( $source_filename, 'w' );
			fwrite( $f, $new_source );
			fclose( $f );
		} else {
			echo $new_source;
		}
	}
}

// Run the CLI only if the file wasn't included.
$included_files = get_included_files();
if ( __FILE__ === $included_files[0] ) {
	$replacetext = new ReplaceText();

	if ( ! isset( $argv[1] ) || ! isset( $argv[2] ) || ! isset( $argv[3] ) ) {
		$replacetext->usage();
	}

	$inplace = false;
	if ( '-i' === $argv[1] ) {
		$inplace = true;
		if ( ! isset( $argv[4] ) ) {
			$replacetext->usage();
		}
		array_shift( $argv );
	}
	$path = $argv[3];

	if ( is_dir( $path ) ) {
		$exclude  = [
			'.CVS',
			'.git',
			'.svn',
			'.hg',
			'build',
			'composer.lock',
			'node_modules',
			'package-lock.json',
			'vendor',
		];

		$replacetext->process_folder( $argv[1], $argv[2], $path, $exclude, $inplace );
	} else {
		$replacetext->process_file( $argv[1], $argv[2], $path, $inplace );
	}
}

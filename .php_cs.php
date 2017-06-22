<?php
declare(strict_types=1);

$finder = \PhpCsFixer\Finder::create();
$config = \PhpCsFixer\Config::create();

$config->setRules([
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'declare_equal_normalize' => true,
    'declare_strict_types' => true,
    'linebreak_after_opening_tag' => true,
    'method_separation' => true,
    'native_function_casing' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_blank_lines_after_phpdoc' => true,
    'no_empty_comment' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_leading_import_slash' => true,
    'no_leading_namespace_whitespace' => true,
    'no_short_bool_cast' => true,
    'no_unreachable_default_argument_value' => true,
    'no_unused_imports' => true,
    'no_useless_else' => true,
    'no_whitespace_before_comma_in_array' => true,
    'no_whitespace_in_blank_line' => true,
    'ordered_imports' => true,
    'protected_to_private' => true,
    'self_accessor' => true,
    'short_scalar_cast' => true,
    'single_blank_line_before_namespace' => true,
    'single_import_per_statement' => true,
    'single_line_after_imports' => true,
    'single_quote' => true,
    'ternary_operator_spaces' => true,
    'trailing_comma_in_multiline_array' => true,
    'whitespace_after_comma_in_array' => true,
]);

$finder
    ->in(__DIR__ . '/test')
    ->in(__DIR__ . '/src')
    ->exclude('test/unit/Fixture');
$config->setFinder($finder);
$config->setRiskyAllowed(true);

return $config;

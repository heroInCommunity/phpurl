<?php
require 'PHP/CodeCoverage/Autoload.php';

$coverage = new PHP_CodeCoverage;
$coverage->start('PhpGaeCurlClassTest');

$coverage->stop();

$writer = new PHP_CodeCoverage_Report_Clover;
$writer->process($coverage, '/tmp/clover.xml');

$writer = new PHP_CodeCoverage_Report_HTML;
$writer->process($coverage, '/tmp/code-coverage-report');
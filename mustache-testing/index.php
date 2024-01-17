<?php

require_once __DIR__ . '/vendor/autoload.php';
$mustache = new Mustache_Engine();

$heading_template = file_get_contents(__DIR__ . '/templates/heading.mustache');
$button_template = file_get_contents(__DIR__ . '/templates/button.mustache');
$text_template = file_get_contents(__DIR__ . '/templates/text.mustache');
$container_template = file_get_contents(__DIR__ . '/templates/container.mustache');
$accordion_item_template = file_get_contents(__DIR__ . '/templates/accordion-item.mustache');
$accordion_template = file_get_contents(__DIR__ . '/templates/accordion.mustache');
$layout_template = file_get_contents(__DIR__ . '/templates/layout.mustache');

function renderApp()
{
    global $mustache, $heading_template, $button_template, $text_template, $container_template, $accordion_item_template, $accordion_template, $layout_template;
    $app_children = [];
    foreach (range(1, 1000) as $i) {

        $heading = $mustache->render($heading_template, ['value' => 'My Page', 'tag' => 'h1']);
        $heading2 = $mustache->render($heading_template, ['value' => 'My Page', 'tag' => 'h1']);
        $button = $mustache->render($button_template, ['classNames' => ['button', 'button-primary'], 'content' => 'Click me']);
        $button2 = $mustache->render($button_template, ['classNames' => ['button', 'button-primary'], 'content' => 'Click me']);
        $text = $mustache->render($text_template, ['classNames' => ['text'], 'value' => 'Lorem Ipsum']);
        $text2 = $mustache->render($text_template, ['classNames' => ['text'], 'value' => 'Lorem Ipsum']);
        $container = $mustache->render($container_template, ['classNames' => ['container'], 'children' => [$heading, $text, $button]]);
        $container1 = $mustache->render($container_template, ['classNames' => ['container'], 'children' => [$heading2, $text2, $button2]]);
        $container2 = $mustache->render($container_template, ['classNames' => ['container'], 'children' => [$text, $heading, $button]]);
        $accordion_item = $mustache->render($accordion_item_template, ['classNames' => ['accordion-item'], 'accordionTitle' => [$heading, $heading2], 'accordionContent' => [$text, $text2]]);
        $accordion_item2 = $mustache->render($accordion_item_template, ['classNames' => ['accordion-item'], 'accordionTitle' => [$heading, $heading2], 'accordionContent' => [$text, $text2]]);
        $accordion = $mustache->render($accordion_template, ['classNames' => ['accordion'], 'children' => [$accordion_item, $accordion_item2]]);


        $app1 = $mustache->render($container_template, ['classNames' => ['container'], 'children' => [$container, $container1, $container2, $accordion]]);
        $app_children[] = $app1;
    }

    $app = $mustache->render($container_template, ['classNames' => ['container'], 'children' => $app_children]);


    // Render the layout with components
     $mustache->render($layout_template, [
        'pageTitle' => 'Mustache Performance Test' . rand(),
        'content' => $app,
    ]);

}
$executions_count = 1;
$time_start = microtime(true);
foreach (range(1, $executions_count) as $i) {
    renderApp();
}
$time_end = microtime(true);
$total_time = ($time_end - $time_start) * 1000;
$execution_time = $total_time / $executions_count;

echo "<b>Mustache Total Execution Time For $executions_count Runs:</b>" . $execution_time . 'ms';

<?php

require_once __DIR__ . '/vendor/autoload.php';
$time_start = microtime(true);

// Create Twig loader and environment
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader);

// Render components
function render()
{
    global $twig;
    $app_children = [];
    foreach (range(1, 1000 ) as $i) {

        $heading = $twig->render('heading.twig', ['value' => 'My Page', 'tag' => 'h1']);
        $heading2 = $twig->render('heading.twig', ['value' => 'My Page', 'tag' => 'h1']);
        $button = $twig->render('button.twig', ['classNames' => ['button', 'button-primary'], 'content' => 'Click me']);
        $button2 = $twig->render('button.twig', ['classNames' => ['button', 'button-primary'], 'content' => 'Click me']);
        $text = $twig->render('text.twig', ['classNames' => [ 'text' ], 'value' => 'Lorem Ipusem' ]);
        $text2 = $twig->render('text.twig', ['classNames' => [ 'text' ], 'value' => 'Lorem Ipusem' ]);
        $container = $twig->render('container.twig', ['classNames' => [ 'container' ], 'children' => [$heading, $text, $button]]);
        $container1 = $twig->render('container.twig', ['classNames' => [ 'container' ], 'children' => [$heading2, $text2, $button2]]);
        $container2 = $twig->render('container.twig', ['classNames' => [ 'container' ], 'children' => [$text, $heading, $button]]);
        $accordion_item = $twig->render('accordion-item.twig', ['classNames' => [ 'accordion-item' ], 'accordionTitle' => [$heading, $heading2], 'accordionContent' => [$text, $text2] ]);
        $accordion_item2 = $twig->render('accordion-item.twig', ['classNames' => [ 'accordion-item' ], 'accordionTitle' => [$heading, $heading2], 'accordionContent' => [$text, $text2] ]);
        $accordion = $twig->render('accordion.twig', ['classNames' => [ 'accordion' ], 'children' => [$accordion_item, $accordion_item2] ] );

        $app1 = $twig->render('container.twig', ['classNames' => [ 'container' ], 'children' => [$container, $container1, $container2, $accordion]]);
        $app_children[] = $app1;
    }

    $app = $twig->render('container.twig', ['classNames' => [ 'container' ], 'children' => $app_children]);

    // Render the layout with components
    $twig->render('layout.twig', [
        'pageTitle' => 'Twig Performance Test',
        'content' => $app,
    ]);

}

$executions_count = 1;
$time_start = microtime(true);
foreach (range(1, $executions_count) as $i) {
    render();
}
$time_end = microtime(true);
$total_time = ($time_end - $time_start) * 1000;
$execution_time = $total_time / $executions_count;

echo "<b>Twig Total Execution Time For $executions_count Runs:</b>" . $execution_time . 'ms';

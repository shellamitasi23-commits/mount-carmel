<?php
$dir = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$ite = new RecursiveIteratorIterator($dir);
$files = new RegexIterator($ite, '/.*\.blade\.php$/', RegexIterator::GET_MATCH);

$count = 0;
foreach($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $original = $content;
    
    // Process <button> tags
    $content = preg_replace_callback('/(<button[^>]+class=[\'"])([^\'"]+)([\'"][^>]*>)/is', function($m) {
        $classes = $m[2];
        $classes = str_replace(['bg-primary', 'bg-slate-900', 'bg-blue-600'], 'bg-[#800000]', $classes);
        $classes = preg_replace('/\btext-primary\b/', 'text-[#800000]', $classes);
        $classes = preg_replace('/\bborder-primary\b/', 'border-[#800000]', $classes);
        $classes = preg_replace('/\bring-primary\b/', 'ring-[#800000]', $classes);
        $classes = preg_replace('/\bhover:bg-primary\b/', 'hover:bg-[#800000]/80', $classes);
        $classes = preg_replace('/\bhover:bg-slate-800\b/', 'hover:bg-[#800000]/80', $classes);
        $classes = preg_replace('/\bhover:bg-black\b/', 'hover:bg-[#800000]/90', $classes);
        $classes = preg_replace('/\bhover:text-primary\b/', 'hover:text-[#800000]/80', $classes);
        return $m[1] . $classes . $m[3];
    }, $content);

    // Process <a> tags that look like buttons
    $content = preg_replace_callback('/(<a[^>]+class=[\'"])([^\'"]+)([\'"][^>]*>)/is', function($m) {
        $classes = $m[2];
        if (preg_match('/\b(btn|bg-primary|bg-slate-900|inline-flex\s+items-center.*px-|bg-blue-600)\b/', $classes)) {
            $classes = str_replace(['bg-primary', 'bg-slate-900', 'bg-blue-600'], 'bg-[#800000]', $classes);
            $classes = preg_replace('/\btext-primary\b/', 'text-[#800000]', $classes);
            $classes = preg_replace('/\bborder-primary\b/', 'border-[#800000]', $classes);
            $classes = preg_replace('/\bring-primary\b/', 'ring-[#800000]', $classes);
            $classes = preg_replace('/\bhover:bg-primary\b/', 'hover:bg-[#800000]/80', $classes);
            $classes = preg_replace('/\bhover:bg-slate-800\b/', 'hover:bg-[#800000]/80', $classes);
            $classes = preg_replace('/\bhover:bg-black\b/', 'hover:bg-[#800000]/90', $classes);
            $classes = preg_replace('/\bhover:text-primary\b/', 'hover:text-[#800000]/80', $classes);
        }
        return $m[1] . $classes . $m[3];
    }, $content);

    if ($original !== $content) {
        file_put_contents($path, $content);
        $count++;
    }
}
echo "Modified $count files.\n";

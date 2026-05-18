<?php
$baseDir = __DIR__ . '/apps';

if (!is_dir($baseDir)) {
    mkdir($baseDir, 0755, true);
}

$categories = array_filter(glob($baseDir . '/*'), 'is_dir');
$categories = array_map('basename', $categories);

$selectedCategory = $_GET['cat'] ?? '';

if ($selectedCategory !== '' && !preg_match('/^[a-zA-Z0-9_-]+$/', $selectedCategory)) {
    die('Security Error: Invalid category format!');
}

if ($selectedCategory !== '' && !in_array($selectedCategory, $categories)) {
    $selectedCategory = '';
}

if ($selectedCategory === '' && count($categories) > 0) {
    $selectedCategory = $categories[0];
}

$apps = [];
if ($selectedCategory !== '') {
    $targetDir = $baseDir . '/' . $selectedCategory;
    $ppmpFiles = glob($targetDir . '/*.ppmp');

    if ($ppmpFiles !== false) {
        foreach ($ppmpFiles as $ppmpPath) {
            $baseName = pathinfo($ppmpPath, PATHINFO_FILENAME);
            $txtPath = $targetDir . '/' . $baseName . '.txt';
            $linkPath = $targetDir . '/' . $baseName . '.link';
            
            $description = 'No description available.';
            if (file_exists($txtPath)) {
                $description = htmlspecialchars(file_get_contents($txtPath));
            }

            $videoLink = '';
            if (file_exists($linkPath)) {
                $videoLink = trim(file_get_contents($linkPath));
            }

            $images = [];
            $searchPatterns = [
                $targetDir . '/' . $baseName . '.png',
                $targetDir . '/' . $baseName . '.jpg',
                $targetDir . '/' . $baseName . '_*.png',
                $targetDir . '/' . $baseName . '_*.jpg'
            ];

            foreach ($searchPatterns as $pattern) {
                $matches = glob($pattern);
                if ($matches !== false) {
                    foreach ($matches as $match) {
                        $images[] = 'apps/' . $selectedCategory . '/' . basename($match);
                    }
                }
            }
            
            $images = array_unique($images);
            sort($images);

            $apps[] = [
                'name' => $baseName,
                'file' => 'apps/' . $selectedCategory . '/' . $baseName . '.ppmp',
                'desc' => $description,
                'images' => $images,
                'videoLink' => $videoLink
            ];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PortaPack Mayhem App Repository</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .neon-green { color: #0f0; text-shadow: 0 0 5px #0f0; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-900 text-gray-300 font-sans antialiased">

    <div class="max-w-6xl mx-auto px-4 py-8">
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-white mb-2"><span class="neon-green">PortaPack</span> App Repo</h1>
            <p class="text-gray-400">Custom Mayhem modules & standalone applications</p>
            
            <div class="mt-6 inline-block bg-gray-800 border border-gray-700 rounded-lg p-4 shadow-lg text-left">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-yellow-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm">
                        <strong class="text-white">Installation:</strong> Download the <code class="bg-gray-900 text-green-400 px-1 rounded">.ppmp</code> file and copy it to the <code class="bg-gray-900 text-green-400 px-1 rounded">/APPS</code> folder on your PortaPack's SD card.
                    </p>
                </div>
            </div>
        </header>

        <div class="flex flex-col md:flex-row gap-8">
            <aside class="w-full md:w-1/4">
                <h2 class="text-xl font-bold text-white mb-4 uppercase tracking-wider text-sm border-b border-gray-700 pb-2">Categories</h2>
                <nav class="flex flex-col space-y-2">
                    <?php if (empty($categories)): ?>
                        <p class="text-gray-500 italic">No categories found.</p>
                    <?php else: ?>
                        <?php foreach ($categories as $cat): ?>
                            <a href="?cat=<?= urlencode($cat) ?>" 
                               class="px-4 py-2 rounded-md transition-colors duration-200 <?php echo ($selectedCategory === $cat) ? 'bg-gray-800 border-l-4 border-green-500 text-white font-semibold' : 'hover:bg-gray-800 text-gray-400 hover:text-white'; ?>">
                                <?= htmlspecialchars($cat) ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </nav>

                <h2 class="text-xl font-bold text-white mt-10 mb-4 uppercase tracking-wider text-sm border-b border-gray-700 pb-2">Links</h2>
                <nav class="flex flex-col space-y-2">
                    <a href="https://hackrf.app" target="_blank" class="px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-800 text-gray-400 hover:text-white flex items-center justify-between group">
                        Mayhem Hub 
                        <svg class="w-4 h-4 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    <a href="https://github.com/htotoo/porta-433" target="_blank" class="px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-800 text-gray-400 hover:text-white flex items-center justify-between group">
                        Porta433
                        <svg class="w-4 h-4 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    <a href="https://ppsplash.creativo.hu/" target="_blank" class="px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-800 text-gray-400 hover:text-white flex items-center justify-between group">
                        Splash screens
                        <svg class="w-4 h-4 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    <a href="https://github.com/htotoo/ppapps" target="_blank" class="px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-800 text-gray-400 hover:text-white flex items-center justify-between group">
                        Web Source
                    <svg class="w-4 h-4 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    <a href="https://github.com/htotoo/mayhem-mdk" target="_blank" class="px-4 py-2 rounded-md transition-colors duration-200 hover:bg-gray-800 text-gray-400 hover:text-white flex items-center justify-between group">
                        Apps Source
                    <svg class="w-4 h-4 opacity-50 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </nav>
            </aside>

            <main class="w-full md:w-3/4">
                <?php if ($selectedCategory === ''): ?>
                    <div class="text-center py-20 text-gray-500">Select a category from the list.</div>
                <?php elseif (empty($apps)): ?>
                    <div class="text-center py-20 bg-gray-800 rounded-xl border border-gray-700">
                        <p class="text-gray-400">No apps have been uploaded to this category yet.</p>
                    </div>
                <?php else: ?>
                    <h2 class="text-2xl font-bold text-white mb-6 capitalize"><?= htmlspecialchars($selectedCategory) ?> <span class="text-gray-600 text-sm font-normal">(<?= count($apps) ?> app<?= count($apps) > 1 ? 's' : '' ?>)</span></h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        <?php foreach ($apps as $app): ?>
                            <?php $safeId = htmlspecialchars($app['name']); ?>
                            <div class="bg-gray-800 rounded-xl border border-gray-700 overflow-hidden shadow-lg transition-transform hover:-translate-y-1 duration-300 flex flex-col">
                                
                                <?php if (!empty($app['images'])): ?>
                                    <div class="relative group">
                                        <div id="gallery-<?= $safeId ?>" class="h-64 flex overflow-x-auto snap-x snap-mandatory scrollbar-hide bg-black border-b border-gray-700 scroll-smooth">
                                            <?php foreach ($app['images'] as $imgSrc): ?>
                                                <div class="snap-center shrink-0 w-full h-full flex items-center justify-center p-2">
                                                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="Screenshot" class="object-contain w-full h-full opacity-90 hover:opacity-100 transition-opacity">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        
                                        <?php if (count($app['images']) > 1): ?>
                                            <button onclick="document.getElementById('gallery-<?= $safeId ?>').scrollBy({left: -300, behavior: 'smooth'})" 
                                                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-gray-900/80 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity border border-gray-600 hover:bg-gray-700 focus:outline-none">
                                                &#10094;
                                            </button>
                                            <button onclick="document.getElementById('gallery-<?= $safeId ?>').scrollBy({left: 300, behavior: 'smooth'})" 
                                                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-gray-900/80 text-white w-8 h-8 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity border border-gray-600 hover:bg-gray-700 focus:outline-none">
                                                &#10095;
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <?php if (count($app['images']) > 1): ?>
                                        <div class="bg-gray-950 text-center text-xs text-gray-400 py-1 font-mono tracking-widest border-b border-gray-700">
                                            ⟷ <?= count($app['images']) ?> IMAGES
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="h-64 bg-gray-900 flex items-center justify-center border-b border-gray-700">
                                        <span class="text-gray-700 font-mono text-sm">[ NO SCREENSHOT ]</span>
                                    </div>
                                <?php endif; ?>

                                <div class="p-5 flex-grow flex flex-col">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-xl font-bold text-white font-mono uppercase truncate mr-2"><?= htmlspecialchars($app['name']) ?>.ppmp</h3>
                                        <?php if (!empty($app['videoLink'])): ?>
                                            <a href="<?= htmlspecialchars($app['videoLink']) ?>" target="_blank" title="Videó megtekintése" class="text-red-500 hover:text-red-400 transition-transform hover:scale-110 flex-shrink-0">
                                                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <p class="text-gray-400 text-sm mb-4 flex-grow whitespace-pre-wrap"><?= $app['desc'] ?></p>
                                    
                                    <a href="<?= htmlspecialchars($app['file']) ?>" download
                                       class="mt-auto block text-center bg-gray-700 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded transition-colors flex items-center justify-center space-x-2 border border-gray-600 hover:border-gray-500">
                                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        <span>Download</span>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </main>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Title Generator - Generate SEO-Friendly Titles Instantly</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Generate catchy and SEO-friendly titles instantly with our AI-powered title generator. Perfect for blogs, articles, and marketing content.">
    <meta name="keywords" content="AI title generator, SEO-friendly titles, blog title generator, catchy titles, AI-powered content">
    <meta name="author" content="Your Brand Name">
    <meta name="robots" content="index, follow">

    <!-- Open Graph for Social Media -->
    <meta property="og:title" content="AI Title Generator - Generate SEO-Friendly Titles Instantly">
    <meta property="og:description" content="Struggling with content ideas? Use our AI-powered tool to generate catchy and SEO-friendly titles for blogs, articles, and more!">
    <meta property="og:image" content="{{ asset('images/ai-title-generator-banner.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="AI Title Generator - Create SEO-Optimized Titles">
    <meta name="twitter:description" content="Use AI to generate high-quality, click-worthy titles for your content.">
    <meta name="twitter:image" content="{{ asset('images/ai-title-generator-banner.jpg') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body::before, body::after {
            content: "";
            position: fixed;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(138,43,226,0.8) 0%, rgba(0,0,0,0) 80%);
            z-index: -1;
        }
        body::before {
            top: 0;
            left: 0;
            border-top-left-radius: 50px;
        }
        body::after {
            bottom: 0;
            right: 0;
            border-bottom-right-radius: 50px;
        }
    </style>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen relative">
    <div class="w-full max-w-lg bg-gray-800 p-8 rounded-2xl shadow-lg text-center relative">
        <h1 class="text-3xl font-bold text-purple-400 mb-4">🚀 AI Title Generator</h1>
        <p class="text-gray-400 mb-6">Generate catchy and SEO-friendly titles for your blogs, articles, and marketing content.</p>
        
        <div id="error-message" class="hidden text-red-400 bg-red-600/20 border border-red-500 rounded-lg px-4 py-2 mb-3"></div>
        <input type="text" name="keyword" id="description" required placeholder="e.g., Golden Hour Photography"
               class="w-full px-4 py-2 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
        <button id="generateTitle"
                class="mt-4 w-full bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 rounded-lg transition duration-300">
            🚀 Generate Titles
        </button>
        
        <div id="result" class="mt-6 hidden">
            <h2 class="text-lg font-semibold text-purple-300 mb-2">✨ Generated Titles:</h2>
            <div id="title-list" class="text-left space-y-4"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // AJAX Call for AI Title Generation
        $(document).ready(function () {
            $('#generateTitle').click(function () {
                let description = $('#description').val().trim();
                $('#error-message').addClass('hidden').text("");
                $('#result').addClass('hidden');
                $('#title-list').empty();
                
                if (description === "") {
                    $('#error-message').removeClass('hidden').text("❌ Please enter a topic or keyword.");
                    return;
                }

                $('#title-list').append("<p class='text-gray-400'>Generating AI-powered titles...</p>");
                $('#result').removeClass('hidden');

                $.ajax({
                    url: "{{ route('title.generate') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        description: description
                    },
                    success: function (response) {
                        $('#title-list').empty();
                        if (Array.isArray(response.titles)) {
                            response.titles.forEach(item => {
                                $('#title-list').append(`
                                    <div class='bg-gray-700 p-4 rounded-lg border border-teal-500 shadow-lg'>
                                        <h3 class='text-teal-300 font-semibold'>✨ ${item}</h3>
                                    </div>
                                `);
                            });
                        } else {
                            $('#title-list').append("<p class='text-teal-300'>✨ " + response.title + "</p>");
                        }
                    },
                    error: function (xhr) {
                        $('#result').addClass('hidden');
                        let errorMessage = "❌ Error generating titles.";
                        if (xhr.status === 422) errorMessage = "⚠️ Invalid input. Please try again.";
                        if (xhr.status === 500) errorMessage = "⚠️ Server error. Please check API key.";
                        $('#error-message').removeClass('hidden').text(errorMessage);
                    }
                });
            });
        });

        // Three.js 3D Background Animation
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({ canvas: document.getElementById('backgroundCanvas'), alpha: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        document.body.appendChild(renderer.domElement);

        const geometry = new THREE.SphereGeometry(0.5, 32, 32);
        const material = new THREE.MeshBasicMaterial({ color: 0x06b6d4, wireframe: true });
        const sphere = new THREE.Mesh(geometry, material);
        scene.add(sphere);

        camera.position.z = 3;

        function animate() {
            requestAnimationFrame(animate);
            sphere.rotation.x += 0.01;
            sphere.rotation.y += 0.01;
            renderer.render(scene, camera);
        }
        animate();
    </script>
</body>
</html>

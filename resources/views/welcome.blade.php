<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Title Generator - Professional SEO Titles</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Generate high-converting, SEO-friendly titles for blogs, marketing, and business content. AI-powered title generation for professionals.">
    <meta name="keywords" content="AI title generator, SEO titles, marketing content, business copywriting, AI-powered writing">
    <meta name="author" content="Your Brand Name">
    <meta name="robots" content="index, follow">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Three.js (for 3D Elements) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f172a, #1e293b);
            overflow-x: hidden;
        }
        .glassmorphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .brand-gradient {
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .button-hover {
            transition: all 0.3s ease-in-out;
        }
        .button-hover:hover {
            transform: scale(1.05);
        }
        .floating {
            position: absolute;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #3b82f6, #06b6d4);
            border-radius: 50%;
            opacity: 0.2;
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen relative">

    <!-- Floating 3D Elements -->
    <div class="floating" style="top: 10%; left: 15%;"></div>
    <div class="floating" style="top: 50%; right: 20%;"></div>
    <div class="floating" style="bottom: 10%; left: 40%;"></div>

    <div class="relative z-10 w-full max-w-lg glassmorphism p-8 rounded-2xl shadow-2xl border border-gray-700 text-center">
        <h1 class="text-3xl font-bold brand-gradient mb-4">🚀 AI Title Generator</h1>
        <p class="text-gray-400 mb-6">Generate high-converting, SEO-friendly titles for your business, blogs, and marketing content.</p>

        <!-- Error Message -->
        <div id="error-message" class="hidden text-red-400 bg-red-600/20 border border-red-500 rounded-lg px-4 py-2 mb-3"></div>

        <!-- Input Field -->
        <div class="relative">
            <input type="text" name="keyword" id="description" required placeholder="e.g., AI Marketing Strategies"
                   class="w-full px-5 py-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button id="generateTitle"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg button-hover transition duration-300">
                🚀 Generate
            </button>
        </div>

        <!-- Generated Title Output -->
        <div id="result" class="mt-6 hidden">
            <h2 class="text-lg font-semibold text-teal-300 mb-2">✨ AI-Generated Titles:</h2>
            <div id="title-list" class="text-left space-y-4"></div>
        </div>
    </div>

    <!-- Three.js Canvas for 3D Animation -->
    <canvas id="backgroundCanvas" class="fixed top-0 left-0 w-full h-full -z-10"></canvas>

    <!-- jQuery & Three.js Script -->
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

<!DOCTYPE html>
<html lang="en"> 

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionary Search</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800&display=swap');

        body {
            background-color: #D6E4F0;
            font-family: 'Nunito', sans-serif;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        p,
        input,
        button {
            font-family: 'Nunito', sans-serif;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .bounce-animation {
            animation: bounce 1.5s infinite;
        }

        @media (max-width: 768px) {
            body {
                padding-left: 16px;
                padding-right: 16px;
            }
        }

        /* Updated pastel purple shades */
        .search-container {
            background-color: rgb(182, 132, 226);
            padding: 20px;
            border-radius: 24px;
        }

        .input-field {
            background-color: #ffffff;
            color: #333;
        }

        .bg-[#C3B1E1] {
            background-color: rgb(132, 63, 243);
        }

        .hover\:bg-[#A68DAD]:hover {
            background-color: rgb(176, 80, 240);
        }

        .focus\:ring-purple-500:focus {
            ring-color: rgb(180, 116, 225);
        }
    </style>
</head>

<body class="bg-blue-100 min-h-screen flex flex-col items-center justify-center">

    <div class="w-full max-w-lg bg-white p-6 rounded-3xl shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-4 text-center">Search a Word</h1>

        <div class="search-container">
            <form method="GET" action="" class="mb-4 grid grid-cols-[1fr_auto] gap-3 items-center">
                <input type="text" name="word" placeholder="Enter a word"
                    class="border w-full p-3 rounded-3xl focus:outline-none focus:ring-2 focus:ring-purple-500 input-field text-lg"
                    required />
                <button type="submit" class="bg-[#C3B1E1] text-white py-3 px-6 rounded-3xl text-lg hover:bg-[#C3B1E1]">
                    Search
                </button>
            </form>
        </div>

        <?php
        if (isset($_GET['word'])) {
            $word = htmlspecialchars($_GET['word']);
            $url = "https://api.dictionaryapi.dev/api/v2/entries/en/$word";

            $response = file_get_contents($url);

            if ($response === FALSE) {
                echo "<p class='text-red-500 mt-4'>Error fetching data from API. Please try again later.</p>";
                exit();
            }

            $data = json_decode($response, true);

            if ($data === NULL) {
                echo "<p class='text-red-500 mt-4'>Invalid response received from API.</p>";
                exit();
            }

            foreach ($data as $entry) {
                echo "<div class='mt-4'>";
                echo "<h2 class='text-2xl font-bold text-blue-800'>$word <span class='text-gray-700'>(" . $entry['meanings'][0]['partOfSpeech'] . ")</span> = <span class='text-black font-bold'>" . $entry['meanings'][0]['definitions'][0]['definition'] . "</span></h2>";

                if (!empty($entry['phonetics'][0]['text'])) {
                    echo "<p><strong>Pronunciation:</strong> " . $entry['phonetics'][0]['text'] . "</p>";
                }

                if (!empty($entry['phonetics'][0]['audio'])) {
                    echo "<audio controls class='mt-2'><source src='" . $entry['phonetics'][0]['audio'] . "' type='audio/mpeg'>Your browser does not support the audio element.</audio>";
                }
                echo "</div>";
            }
        }
        ?>
    </div>

    <a href="mailto:heliabrs40@gmail.com"
        class="fixed bottom-16 right-8 bg-blue-500 text-white rounded-3xl p-3 shadow-lg hover:bg-blue-600 transition bounce-animation text-md"
        title="Email Us" style="padding-left:18px;padding-right:18px; display:flex;align-items:center;">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M12 12c2.211 0 4-1.789 4-4s-1.789-4-4-4-4 1.789-4 4 1.789 4 4 4zM12 14c-3.313 0-6 1.687-6 3v2h12v-2c0-1.313-2.687-3-6-3z" />
        </svg>
        &nbsp;Dictionary By Helia
    </a>

</body>
</html>

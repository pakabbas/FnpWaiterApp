<?php
$generated = false;

if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['text'])) {
    $apiKey = 'sk_d5b4eba7c6d5aaf461c10fc4f54068a07269b94a6caa3509';
    $voiceId = 'EXAVITQu4vr4xnSDxMaL';
    $text = $_POST['text'];

    $data = [
        "text" => $text,
        "model_id" => "eleven_monolingual_v1",
        "voice_settings" => [
            "stability" => 0.5,
            "similarity_boost" => 0.5
        ]
    ];

    $ch = curl_init("https://api.elevenlabs.io/v1/text-to-speech/$voiceId");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "xi-api-key: $apiKey",
        "Content-Type: application/json",
        "Accept: audio/mpeg"
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);

    file_put_contents("output.mp3", $response);
    $generated = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ElevenLabs TTS</title>
</head>
<body style="font-family:sans-serif;padding:30px;">
    <h2>Text to Speech Generator (ElevenLabs)</h2>
    <form method="POST">
        <textarea name="text" rows="4" cols="60" placeholder="Enter your text here..." required></textarea><br><br>
        <button type="submit">🔊 Generate Speech</button>
    </form>

    <?php if ($generated): ?>
        <h3>✅ Audio Generated:</h3>
        <audio controls autoplay>
            <source src="output.mp3" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    <?php endif; ?>
</body>
</html>

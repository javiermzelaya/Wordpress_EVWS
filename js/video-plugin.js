document.addEventListener('DOMContentLoaded', function() {
    const subtitleInput = document.getElementById('subtitle-input');
    const videoPlayer = document.getElementById('video-player');

    subtitleInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function() {
            let text = reader.result;

            if (file.name.endsWith('.srt')) {
                text = convertToUTF8(text);
                text = fixSpanishCharacters(text);
                text = convertSRTtoVTT(text);
            } else {
                text = fixSpanishCharacters(text);
            }

            // Crear un Blob y URL
            const blob = new Blob([text], { type: 'text/vtt' });
            const url = URL.createObjectURL(blob);

            // Eliminar los tracks existentes para evitar duplicados
            const existingTracks = videoPlayer.querySelectorAll('track');
            existingTracks.forEach(track => track.remove());

            // Crear y añadir el nuevo track
            const track = document.createElement('track');
            track.kind = 'subtitles';
            track.label = 'Spanish';
            track.srclang = 'es';
            track.src = url;
            videoPlayer.appendChild(track);

            // Forzar la actualización de los tracks del video
            if (videoPlayer.textTracks.length > 0) {
                videoPlayer.textTracks[0].mode = 'showing';
            }
        };

        reader.readAsText(file);
    });

    function convertToUTF8(text) {
        const encoder = new TextEncoder();
        const uint8Array = encoder.encode(text);
        const decoder = new TextDecoder('utf-8');
        return decoder.decode(uint8Array);
    }

    function fixSpanishCharacters(text) {
        const charMap = {
            'Ã¡': 'á', 'Ã©': 'é', 'Ã­': 'í', 'Ã³': 'ó', 'Ãº': 'ú', 'Ã±': 'ñ',
            'Ã': 'Á', 'Ã‰': 'É', 'Ã': 'Í', 'Ã“': 'Ó', 'Ãš': 'Ú', 'Ã‘': 'Ñ',
            'Â¿': '¿', 'Â¡': '¡'
        };
        return text.replace(/Ã¡|Ã©|Ã­|Ã³|Ãº|Ã±|Ã|Ã‰|Ã|Ã“|Ãš|Ã‘|Â¿|Â¡/g, match => charMap[match] || match);
    }

    function convertSRTtoVTT(text) {
        return 'WEBVTT\n\n' + text
            .replace(/(\d+:\d+:\d+),(\d+)/g, '$1.$2')
            .replace(/ --> /g, ' --> ')
            .replace(/\r?\n|\r/g, '\n')
            .replace(/\n\n+/g, '\n\n');
    }
});
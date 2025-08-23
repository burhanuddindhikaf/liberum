{{-- Simple Background Music Toggle --}}
<div id="backgroundMusicPlayer" class="fixed bottom-4 right-4 z-50">
    <div class="bg-white rounded-full shadow-lg p-3 border border-gray-200 hover:shadow-xl transition-all duration-300">
        {{-- Simple Toggle Button --}}
        <button id="musicToggle" class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            {{-- Music ON Icon --}}
            <svg id="musicOnIcon" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3z" clip-rule="evenodd"></path>
            </svg>
            {{-- Music OFF Icon --}}
            <svg id="musicOffIcon" class="w-6 h-6 hidden" fill="currentColor" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 3a1 1 0 00-1.196-.98l-10 2A1 1 0 006 5v9.114A4.369 4.369 0 005 14c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V7.82l8-1.6v5.894A4.369 4.369 0 0015 12c-1.657 0-3 .895-3 2s1.343 2 3 2 3-.895 3-2V3zM6 18L18 6"></path>
            </svg>
        </button>
    </div>

    {{-- Hidden Audio Element --}}
    <audio id="backgroundAudio" loop>
        <source src="{{ asset('music/10 - Date.mp3') }}" type="audio/mpeg">
        <source src="{{ asset('music/background-music.mp3') }}" type="audio/mpeg">
        <source src="{{ asset('music/background-music.ogg') }}" type="audio/ogg">
        Your browser does not support the audio element.
    </audio>
</div>

{{-- Simple Music Toggle JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('backgroundAudio');
    const musicToggle = document.getElementById('musicToggle');
    const musicOnIcon = document.getElementById('musicOnIcon');
    const musicOffIcon = document.getElementById('musicOffIcon');
    const musicPlayer = document.getElementById('backgroundMusicPlayer');

    let isPlaying = false;

    // Set initial audio properties
    audio.volume = 0.3;
    audio.loop = true; // Ensure loop is enabled

    console.log('Background music initialized - Loop enabled:', audio.loop);

    // Check if user has previously disabled music
    const musicDisabled = localStorage.getItem('musicDisabled');
    if (musicDisabled === 'true') {
        setMusicOff();
        return;
    }

    // Try to auto-play music
    setTimeout(() => {
        audio.play().then(() => {
            setMusicOn();
        }).catch(error => {
            console.log('Auto-play failed:', error);
            setMusicOff();
        });
    }, 1000);

    // Toggle music on/off
    musicToggle.addEventListener('click', function() {
        if (isPlaying) {
            audio.pause();
            setMusicOff();
            localStorage.setItem('musicDisabled', 'true');
        } else {
            audio.play().then(() => {
                setMusicOn();
                localStorage.setItem('musicDisabled', 'false');
            }).catch(error => {
                console.log('Play failed:', error);
            });
        }
    });

    function setMusicOn() {
        isPlaying = true;
        musicOnIcon.classList.remove('hidden');
        musicOffIcon.classList.add('hidden');
        musicToggle.classList.remove('bg-gray-500');
        musicToggle.classList.add('bg-blue-500', 'animate-pulse');
    }

    function setMusicOff() {
        isPlaying = false;
        musicOnIcon.classList.add('hidden');
        musicOffIcon.classList.remove('hidden');
        musicToggle.classList.remove('bg-blue-500', 'animate-pulse');
        musicToggle.classList.add('bg-gray-500');
    }

    // Handle audio events
    audio.addEventListener('play', function() {
        setMusicOn();
    });

    audio.addEventListener('pause', function() {
        setMusicOff();
    });

    // Ensure loop functionality
    audio.addEventListener('ended', function() {
        // Double check loop is working
        if (audio.loop) {
            audio.currentTime = 0;
            audio.play().catch(error => {
                console.log('Loop restart failed:', error);
            });
        }
    });

    // Handle when audio is ready to play
    audio.addEventListener('canplay', function() {
        console.log('Audio ready to play - Loop enabled:', audio.loop);
    });

    audio.addEventListener('error', function() {
        console.log('Audio failed to load');
        musicPlayer.style.display = 'none';
    });

    // Restore music state when navigating between pages
    const musicState = localStorage.getItem('musicDisabled');
    if (musicState === 'false') {
        setTimeout(() => {
            audio.play().catch(error => {
                console.log('Restore play failed:', error);
            });
        }, 500);
    }

    // Show music player with animation
    musicPlayer.style.opacity = '0';
    musicPlayer.style.transform = 'translateY(20px)';
    setTimeout(() => {
        musicPlayer.style.transition = 'all 0.3s ease-out';
        musicPlayer.style.opacity = '1';
        musicPlayer.style.transform = 'translateY(0)';
    }, 500);
});
</script>

{{-- Simple Styles --}}
<style>
#backgroundMusicPlayer {
    transition: all 0.3s ease-out;
}

.animate-pulse {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}
</style>

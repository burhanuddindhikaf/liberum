{{-- Universal Background Music Player --}}
@php
    $currentRoute = request()->route()->getName();
    $excludedRoutes = ['login', 'register', 'password.request', 'password.reset', 'verification.notice', 'password.confirm'];
    $isExcluded = in_array($currentRoute, $excludedRoutes) || 
                  str_contains(request()->path(), 'login') || 
                  str_contains(request()->path(), 'register') ||
                  str_contains(request()->path(), 'password') ||
                  str_contains(request()->path(), 'verify');
@endphp

@unless($isExcluded)
<div id="backgroundMusicPlayer" class="fixed bottom-4 right-4 z-50">
    <div class="bg-white rounded-full shadow-lg p-3 border border-gray-200 hover:shadow-xl transition-all duration-300">
        {{-- Music Toggle Button --}}
        <button id="musicToggle" class="flex items-center justify-center w-12 h-12 rounded-full bg-blue-500 text-white hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" title="Toggle Background Music">
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
    <audio id="backgroundAudio" loop preload="auto">
        <source src="{{ asset('music/10 - Date.mp3') }}" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio>
</div>

<script>
// Global music player that works across all pages
(function() {
    'use strict';

    // Prevent multiple instances
    if (window.GlobalMusicPlayer) {
        return;
    }

    window.GlobalMusicPlayer = {
        audio: null,
        musicToggle: null,
        musicOnIcon: null,
        musicOffIcon: null,
        musicPlayer: null,
        isPlaying: false,

        init: function() {
            document.addEventListener('DOMContentLoaded', () => {
                // Skip music on login/register pages
                if (this.shouldSkipMusic()) {
                    return;
                }

                this.setupElements();
                this.setupAudio();
                this.setupEvents();
                this.restoreState();
                this.showPlayer();
            });
        },

        shouldSkipMusic: function() {
            const currentPath = window.location.pathname;
            const skipPages = [
                '/login',
                '/register',
                '/forgot-password',
                '/reset-password',
                '/verify-email',
                '/confirm-password'
            ];

            return skipPages.some(page => currentPath.includes(page));
        },

        setupElements: function() {
            this.audio = document.getElementById('backgroundAudio');
            this.musicToggle = document.getElementById('musicToggle');
            this.musicOnIcon = document.getElementById('musicOnIcon');
            this.musicOffIcon = document.getElementById('musicOffIcon');
            this.musicPlayer = document.getElementById('backgroundMusicPlayer');

            if (!this.audio || !this.musicToggle) {
                console.log('Music elements not found');
                return false;
            }
            return true;
        },

        setupAudio: function() {
            if (!this.audio) return;

            this.audio.volume = 0.3;
            this.audio.loop = true;
            console.log('🎵 Global music player initialized');
        },

        setupEvents: function() {
            if (!this.musicToggle) return;

            // Toggle button click
            this.musicToggle.addEventListener('click', () => {
                this.toggle();
            });

            // Audio events
            this.audio.addEventListener('play', () => {
                this.setMusicOn();
            });

            this.audio.addEventListener('pause', () => {
                this.setMusicOff();
            });

            this.audio.addEventListener('error', (e) => {
                console.log('Audio error:', e);
                this.hidePlayer();
            });

            // Save state before page unload
            window.addEventListener('beforeunload', () => {
                this.saveState();
            });
        },

        toggle: function() {
            if (!this.audio) return;

            if (this.isPlaying) {
                this.pause();
            } else {
                this.play();
            }
        },

        play: function() {
            if (!this.audio) return;

            this.audio.play().then(() => {
                this.setMusicOn();
                localStorage.setItem('musicEnabled', 'true');
                console.log('🎵 Music started');
            }).catch(error => {
                console.log('Play failed:', error.message);
                this.setMusicOff();
            });
        },

        pause: function() {
            if (!this.audio) return;

            this.audio.pause();
            this.setMusicOff();
            localStorage.setItem('musicEnabled', 'false');
            console.log('🎵 Music paused');
        },

        setMusicOn: function() {
            this.isPlaying = true;
            if (this.musicOnIcon && this.musicOffIcon && this.musicToggle) {
                this.musicOnIcon.classList.remove('hidden');
                this.musicOffIcon.classList.add('hidden');
                this.musicToggle.classList.remove('bg-gray-500');
                this.musicToggle.classList.add('bg-blue-500', 'animate-pulse');
                this.musicToggle.title = 'Pause Music';
            }
        },

        setMusicOff: function() {
            this.isPlaying = false;
            if (this.musicOnIcon && this.musicOffIcon && this.musicToggle) {
                this.musicOnIcon.classList.add('hidden');
                this.musicOffIcon.classList.remove('hidden');
                this.musicToggle.classList.remove('bg-blue-500', 'animate-pulse');
                this.musicToggle.classList.add('bg-gray-500');
                this.musicToggle.title = 'Play Music';
            }
        },

        restoreState: function() {
            const musicEnabled = localStorage.getItem('musicEnabled');
            const musicTime = localStorage.getItem('musicTime');
            const musicVolume = localStorage.getItem('musicVolume');

            // Restore volume
            if (musicVolume && this.audio) {
                this.audio.volume = parseFloat(musicVolume);
            }

            // Restore time position
            if (musicTime && this.audio) {
                this.audio.currentTime = parseFloat(musicTime);
            }

            // Restore playing state with delay for autoplay policies
            if (musicEnabled === 'true') {
                setTimeout(() => {
                    this.play();
                }, 1000);
            } else {
                this.setMusicOff();
            }
        },

        saveState: function() {
            if (!this.audio) return;

            localStorage.setItem('musicEnabled', this.isPlaying ? 'true' : 'false');
            localStorage.setItem('musicTime', this.audio.currentTime.toString());
            localStorage.setItem('musicVolume', this.audio.volume.toString());
        },

        showPlayer: function() {
            if (!this.musicPlayer) return;

            this.musicPlayer.style.opacity = '0';
            this.musicPlayer.style.transform = 'translateY(20px)';

            setTimeout(() => {
                this.musicPlayer.style.transition = 'all 0.3s ease-out';
                this.musicPlayer.style.opacity = '1';
                this.musicPlayer.style.transform = 'translateY(0)';
            }, 500);
        },

        hidePlayer: function() {
            if (this.musicPlayer) {
                this.musicPlayer.style.display = 'none';
            }
        }
    };

    // Initialize the global music player
    window.GlobalMusicPlayer.init();
})();
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
@endunless

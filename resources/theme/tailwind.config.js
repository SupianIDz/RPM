import preset from '../../vendor/filament/filament/tailwind.config.preset';

export default {
    presets: [preset],
    content: [
        './app/**/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
        './vendor/octopyid/**/*.blade.php',
        './vendor/archilex/filament-toggle-icon-column/**/*.php',
    ],
};

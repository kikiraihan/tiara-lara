<style>
    /* Animasi ikon saat toggle */
    #darkModeToggle i {
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    #darkModeToggle i.hide {
        transform: scale(0);
        opacity: 0;
        pointer-events: none;
    }

    #darkModeToggle i.show {
        transform: scale(1);
        opacity: 1;
        pointer-events: auto;
    }
</style>


<script>
    const darkModeToggle = document.getElementById('darkModeToggle');
    const html = document.documentElement;

    // Create icons dynamically
    const darkModeIcon = document.createElement('i');
    const lightModeIcon = document.createElement('i');

    darkModeIcon.className = 'fas fa-moon show';
    lightModeIcon.className = 'fas fa-sun hide';

    // Add icons to the toggle button
    darkModeToggle.appendChild(darkModeIcon);
    darkModeToggle.appendChild(lightModeIcon);

    // Apply the saved mode on page load
    const savedMode = localStorage.getItem('darkMode');
    if (savedMode === 'enabled') {
        html.classList.add('dark');
        darkModeIcon.classList.replace('hide','show');
        lightModeIcon.classList.replace('show','hide');
    } else {
        html.classList.remove('dark');
        lightModeIcon.classList.replace('hide','show');
        darkModeIcon.classList.replace('show','hide');
    }

    // Toggle dark mode and save preference
    darkModeToggle.addEventListener('click', () => {
        const isDark = html.classList.toggle('dark');

        if (isDark) {
            darkModeIcon.classList.replace('hide','show');
            lightModeIcon.classList.replace('show','hide');
        } else {
            lightModeIcon.classList.replace('hide','show');
            darkModeIcon.classList.replace('show','hide');
        }

        // Save the preference in LocalStorage
        localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
    });
</script>

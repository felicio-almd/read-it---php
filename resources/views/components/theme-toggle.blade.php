<?php

declare(strict_types=1);

?>
<button
    id="theme-toggle"
    type="button"
    class="relative m-0 inline-flex items-center justify-center rounded-lg p-2 transition-colors duration-200 hover:bg-gray-300"
    aria-label="Alternar tema"
>
    {{-- Ícone Sol (tema claro) --}}
    <x-lucide-sun id="theme-toggle-light-icon" class="hidden h-5 w-5 dark:block" />

    {{-- Ícone Lua (tema escuro) --}}
    <x-lucide-moon id="theme-toggle-dark-icon" class="h-5 w-5 dark:hidden" />
</button>

<script>
    // Função para definir o tema
    function setTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    }

    // Verificar tema salvo ou preferência do sistema
    function getInitialTheme() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            return savedTheme;
        }
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // Aplicar tema inicial
    setTheme(getInitialTheme());

    // Evento de clique no botão
    document.getElementById('theme-toggle').addEventListener('click', function () {
        const isDark = document.documentElement.classList.contains('dark');
        setTheme(isDark ? 'light' : 'dark');
    });
</script>
<?php 

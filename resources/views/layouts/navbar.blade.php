<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">

    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            MIRAI GRESIK SYSTEM
        </a>

        <div class="ms-auto">
<button
    id="pwa-install-button"
    type="button"
    onclick="window.installPwa()"
    class="hidden inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600"
>
    📱 Install MGS
</button>
            <span class="text-white me-3">

                {{ Auth::user()->name }}

            </span>

            <form action="{{ route('logout') }}" method="POST" class="d-inline">

                @csrf

                <button class="btn btn-sm btn-light">
                    Logout
                </button>

            </form>

        </div>

    </div>

</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const installButton = document.getElementById('pwa-install-button');

        if (!installButton) {
            return;
        }

        window.addEventListener('pwa-install-available', () => {
            installButton.classList.remove('hidden');
        });

        window.addEventListener('pwa-installed', () => {
            installButton.classList.add('hidden');
        });

        window.addEventListener('pwa-install-finished', () => {
            installButton.classList.add('hidden');
        });
    });
</script>